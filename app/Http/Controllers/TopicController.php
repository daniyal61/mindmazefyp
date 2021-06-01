<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Answer;
use App\User;
class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::all();
        return view('admin.quiz.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $input = $request->all();
        $request->validate([
          'title' => 'required|string',
          'level' => 'required',
          'quiz_code' => 'string',
          'per_q_mark' => 'required',
          
          
          
        ]);

        if(isset($request->quiz_price)){
          $request->validate([
            'amount' => 'required'
          ]);
        }

        if(isset($request->quiz_price)){
          $input['amount'] = $request->amount;
        }else{
          $input['amount'] = null;
        }

        if(isset($request->show_ans)){
          $input['show_ans'] = "1";
        }else{
          $input['show_ans'] = "0";
        }

       // $input = $request->all();
           $quiz = Topic::create($input);


          $users = User::select('device_token')->pluck('device_token')->filter();

          foreach($users as $key =>$value){

          $push_notification_key = "AAAABsytADE:APA91bEhWy0BiJbbVG6yNGK2GPE5XxI43ntYtqCg5iVTnIcOQMXQScwZVV9lzTPhq5Qm9MfCGVQM3eSDbTZxeugoNzroPrAxv4_w0npxZdIZL02duMpk9LpUEznSdVI0KrAWikBB16Bz";    
          $url = "https://fcm.googleapis.com/fcm/send";            
            $header = array("authorization: key=" . $push_notification_key . "",
            "content-type: application/json"
            );    

            $postdata = '{
            "to" : "' . $value . '",
                "data" : {
                "id" : "1",
                "title":"QuizIT",
                "description" : "New Quiz has been added '.$request->quiz_code.'",
                "text" : "",
                "is_read": 0,
                "tag": ""
              }
            }';

            $ch = curl_init();
            $timeout = 120;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            // Get URL content
            $result = curl_exec($ch);    
            // close handle to release resources
            curl_close($ch);
            }
           
       // $input['show_ans'] = $request->show_ans;
        //return Topic::create($input);
        return back()->with('added', 'Topic has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

          'title' => 'required|string',
          'per_q_mark' => 'required'
          
        ]);

        if(isset($request->pricechk)){
          $request->validate([
            'amount' => 'required'
          ]);
        }

          $topic = Topic::findOrFail($id);
          
          $topic->title = $request->title;
          $topic->description = $request->description;
          $topic->per_q_mark = $request->per_q_mark;
          $topic->timer = $request->timer;

          if(isset($request->show_ans)){
            $topic->show_ans = 1;
          }else{
            $topic->show_ans = 0;
            
          }

          if(isset($request->pricechk)){
            $topic->amount = $request->amount;
          }else{
            $topic->amount = NULL;
          }

         

          $topic->save();

          return back()->with('updated','Topic updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return back()->with('deleted', 'Topic has been deleted');
    }

    public function deleteperquizsheet($id)
    {
      $findanswersheet = Answer::where('topic_id','=',$id)->get();

      if($findanswersheet->count()>0){
        foreach ($findanswersheet as $value) {
          $value->delete();
        }
      
        return back()->with('deleted','Answer Sheet Deleted For This Quiz !');

      }else{
        return back()->with('added','No Answer Sheet Found For This Quiz !');
      }
      

    }
}
