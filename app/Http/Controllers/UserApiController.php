<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Config;
use JWTAuth;
use DB;
use Log;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Notification;

use Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;
use App\Notifications\ResetPasswordOTP;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Card;

use App\User;
use App\Topic;
use App\Question;
use App\Answer;
use App\Provider;
use App\Settings;

use Mail;
use App\UserRequests;

use Image;
use App\Http\Controllers\ProviderResources\TripController;

class UserApiController extends Controller

{
     /**
     * Signup Patient.
     *
     * @return \Illuminate\Http\Response
     */

    public function signup(Request $request)

    {
        $this->validate($request, [
                'device_type' => '',
                'device_token' => 'required',
                'device_id' => 'required',
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'mobile' => 'required',
                'address' => 'max:255',
                'city' => 'required|max:255',
                'hospital_name' => 'required|max:255',
                'password' => 'required|min:6',
                'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            ]);

        try{

            $User = $request->all();

            $users = User::where('email', $request->email)->get();
   
            if(sizeof($users) > 0){
      
             return response()->json([
                'status'=>'201',
                'message' => 'Email Already Exists.',
            ]);
            }


            $User['password'] = bcrypt($request->password);

            $User['status'] = '0';
			
			$User['role'] = 'S';

            $User = User::create($User);

            

        $to_email=$request->email;
        $token=Str::random(300);

        $link = 'projects.funtash.net/quickquiz/public/api/user_verification/' . $token . '?email=' .  urlencode($to_email);
        
        
        $subject="Email Verification";
        $message_body="$link";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From: <webmaster@example.com>' . "\r\n";
        $headers .= 'Cc: myboss@example.com' . "\r\n";
            
        Mail::send([], [], function ($message) use ($to_email, $subject,$message_body) {
            
        $message->to($to_email)
        ->subject($subject)
        // here comes what you want
        ->setBody($message_body); // assuming text/plain
        });

             return response()->json([
                'status'=>'200',
                'message' => 'User Registered Successfully.',
                'data' => $User,
            ]);


        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Patient Login.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function userlogin(Request $request)
    {
        try{
     
        $user=User::where('email',$request->email)->first();

        if(empty($user)){

                return response()->json([
                'code'=>'201',
                'message' => 'Record Does not exist',
               
            ]);
         }

       /* if($user->status == 0){

                return response()->json([
                'code'=>'201',
                'message' => 'Please Verify Your Email',
               
            ]);
         }
  */
        if(auth()->attempt(['email'=>$request['email'], 'password'=>$request['password']])){

            $user->device_id=$request->device_id;
            $user->device_token=$request->device_token;
            $user->save();
            return response()->json([
                'code'=>'200',
                'message' => 'User Login Successfully.',
                'data' => $user,
            ]);
        }else{
            return response()->json([
                'code'=>'201',
                'message' => 'Email/Password not matched',
               
            ]);
        }

         } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Logout Patient.
     *
     * @return \Illuminate\Http\Response
     */

    public function userlogout(Request $request)

    {
        $this->validate($request, [
                'user_id' => 'required',
            ]);

        try {

            User::where('id', $request->user_id)->update(['device_id' => '','device_token' => '']);

            return response()->json([
                 'code'=>'200',
                 'message' => 'Logout Successfully'
             ]);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Store Profile.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function get_user_profile(Request $request)
    {
         $this->validate($request, [
                'id' => 'max:255',
            ]);

        try{
     
        $user=User::where('id',$request->id)->get();

        if(!empty($user)){

            return response()->json([
                'code'=>'200',
                'message' => 'User Details.',
                'data' => $user,
            ]);
        }else{
            return response()->json([
                'code'=>'201',
                'message' => 'Not Found',
               
            ]);
        }

         } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Store Profile.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function getquizzcodes(Request $request)
    {

        try{
     
        $user = Topic::where('created_at', '>=', Carbon::today())->pluck('quiz_code');

        if(!empty($user)){

            return response()->json([
                'code'=>'200',
                'message' => 'Quiz Codes.',
                'data' => $user,
            ]);
        }else{
            return response()->json([
                'code'=>'201',
                'message' => 'Not Found',
               
            ]);
        }

         } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Store Profile.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function getquizz(Request $request)
    {
         $this->validate($request, [
                'quiz_code' => 'max:255',
			    'user_id' => 'max:255',
            ]);

        try{
     
        $user=Topic::where('quiz_code',$request->quiz_code)->with('question')->get();
			
			$topicid = Topic::where('quiz_code',$request->quiz_code)->value('id');
			
			
		    $getuser = Answer::where('topic_id',$topicid)->where('user_id',$request->user_id)->get();
			
			$scores = Answer::where('topic_id',$topicid)
        ->where('user_id',$request->user_id)->sum('score');
			
			

        $topic = Topic::findOrFail($topicid);

        $c_que = Question::where('topic_id', $topicid)->count();

        $total_marks = $c_que*$topic->per_q_mark;
			
		   if($getuser->isNotEmpty()){
                return response()->json([
                'code'=>'202',
                'message' => 'Already Submitted',
				'Total Marks' => $total_marks,
                'Scores Got' => $scores,
               
            ]);
         }

        if(!empty($user)){

            return response()->json([
                'code'=>'200',
                'message' => 'Quiz Details.',
                'data' => $user,
            ]);
        }else{
            return response()->json([
                'code'=>'201',
                'message' => 'Not Found',
               
            ]);
        }

         } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Signup Patient.
     *
     * @return \Illuminate\Http\Response
     */

    public function answerquizz(Request $request)

    {
        $this->validate($request, [
                'topic_id' => 'max:255',
                'user_id' => 'max:255',
                'question_id' => 'max:255',
                'user_answer' => 'max:255',
                'answer' => 'max:255',
                'score' => 'max:255',
            ]);

        try{

            $User = $request->all();
			
			//$getuser = Answer::where('user_id',$request->user_id)
				//->where('topic_id',$request->topic_id)
				//->where('question_id',$request->question_id)->get();
			
		
			
		//if($getuser->isNotEmpty()){
               // return response()->json([
                //'code'=>'202',
                //'message' => 'Already Submitted',
               
            //]);
         //}
			
			if(!empty($request->user_answer)){

            if($request->user_answer != $request->answer){

                $User['score'] = 0;

            } else{

                $topic = Topic::findOrFail($request->topic_id);

                $User['score'] = $topic->per_q_mark;

            }
				
			} else{
			       $User['score'] = 0;
			}
			
             $User = Answer::create($User);
			

             return response()->json([
                'status'=>'200',
                'message' => 'Submitted Successfully.',
                'data' => $User,
            ]);


        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

   /**
     * Store Profile.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function getscores(Request $request)
    {
         $this->validate($request, [
                'topic_id' => 'max:255',
                'user_id' => 'max:255',
            ]);

        try{
     
        $scores = Answer::where('topic_id',$request->topic_id)
        ->where('user_id',$request->user_id)->sum('score');
			
			

        $topic = Topic::findOrFail($request->topic_id);

        $c_que = Question::where('topic_id', $request->topic_id)->count();

        $total_marks = $c_que*$topic->per_q_mark;
			

        if($scores >="0"){

            return response()->json([
                'code'=>'200',
                'message' => 'Score Details.',
                'Total Marks' => $total_marks,
                'Scores Got' => $scores,
            ]);
        }else{
            return response()->json([
                'code'=>'201',
                'message' => 'Not Found',
               
            ]);
        }

         } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }



    
    /**
     * Update Patient Profile.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_profile_user(Request $request){

        $this->validate($request, [
                'name' => 'max:255',
                'last_name' => 'max:255',
                'mobile' => '',
                'hospital_name' => '',
                'address' => '',

            ]);

         try {

            $user = User::findOrFail($request->id);

            if($request->has('name')){ 

                $user->name = $request->name;
            }

            if($request->has('last_name')){

                $user->last_name = $request->last_name;
            }

            if($request->has('mobile')){

                $user->mobile = $request->mobile;
            }

            if($request->has('hospital_name')){

                $user->hospital_name = $request->hospital_name;
            }

            if($request->has('address')){

                $user->address = $request->address;
            }


            $user->save();

           return response()->json([
                'code'=>'200',
                'message' => 'Profile Updated Successfully',
                'data' => $user,
               
            ]);
        }
        catch (ModelNotFoundException $e) {
             return response()->json(['error' => trans('api.user.user_not_found')], 500);
        }
    }


  
    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function change_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'old_password' => 'required',
            ]);

        $User = Auth::user();

        if(Hash::check($request->old_password, $User->password))
        {
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            }else{
                return back()->with('flash_success', 'Password Updated');
            }
        } else {
            return response()->json(['error' => trans('api.user.incorrect_password')], 500);
        }
    }


    /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function forgotPassword(Request $request)
    {
        //
        if(User::where('email',$request->email)->exists()){
            $to_email=$request->email;

        $token=Str::random(100);
        $link = 'projects.funtash.net/quickquiz/public/api/' . 'forgot-user-password/' . $token . '?email=' . urlencode($to_email);
        
        
        $subject="Forgot Password";
        $message_body="$link";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From: <webmaster@example.com>' . "\r\n";
        $headers .= 'Cc: myboss@example.com' . "\r\n";
            
        Mail::send([], [], function ($message) use ($to_email, $subject,$message_body) {
            
        $message->to($to_email)
        ->subject($subject)
        // here comes what you want
        ->setBody($message_body); // assuming text/plain
        });

         return response()->json(array('code' => '1', 'message' => 'Check your email!'), 200);
    
        }else{
             return response()->json(array('code' => '0', 'message' => 'Email not found!'), 200);
        }

    }

     /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function showforgotPassword()
    {
        return view('forget_password');
    }


     /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function updatePassword(Request $request)
    {
        $pass = $request->password;
        $User = User::where('email',$request->email)->update(['password'=>bcrypt($pass)]);

        $response_message = array('msg' => 'Password Updated Successfully!', 'status' => true);
            
        return Response()->json($response_message);
    }

     

    public function userEmailVerification(Request $request)
    {
         if(User::where(['email'=>$request->email,'status'=>'1'])->exists()){
             $message= "Email Already Verified";
            
            return view('email_verify')->with(compact('message','email'));
         }else if(User::where(['email'=>$request->email])->exists()){
             $user = User::where(['email'=>$request->email])->update([
                'status' => '1',
               
            ]); 
              $message= "Email Verified Successfully";
            
            return view('email_verify')->with(compact('message','email'));
         }else{
            $email="";
             $message= "Email Already Verified";
            
            return view('email_verify')->with(compact('message','email'));
         }
        
             
    }

     
}

