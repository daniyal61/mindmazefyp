<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Topic;
use App\Answer;
use App\Friend_invite;
use App\Chat;
use Session;
class MainQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        Answer::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $topic = Topic::findOrFail($id);
          $auth = Auth::user();
        
          Answer::where('user_id', $auth->id)->where('topic_id', $topic->id)->delete();
          if ($auth) {
            // if ($answers = Answer::where('user_id', $auth->id)->get()) {
            //     $all_questions = collect();
            //     $q_filter = collect();
            //     foreach ($answers as $answer) {
            //       $q_id = $answer->question_id;
            //       $q_filter = $q_filter->push(Question::where('id', $q_id)->get());
            //     }
            //     $all_questions = $all_questions->push(Question::where('topic_id', $topic->id)->get());
            //     $all_questions = $all_questions->flatten();
            //     $q_filter = $q_filter->flatten();
            //     $questions = $all_questions->diff($q_filter);
            //     $questions = $questions->flatten();
            //     $questions = $questions->shuffle();
            //     return response()->json(["questions" => $questions, "auth"=>$auth, "topic" => $topic->id]);
            // }
            $dlevel = Session::get('dlevel');
            $questions = collect(); 
            $questions = Question::where('topic_id', $topic->id)->where('type',$dlevel)->get();
            $questions = $questions->flatten();
            $questions = $questions->shuffle();
            return response()->json(["questions" => $questions, "auth"=>$auth]);
          }
          return redirect('/');
    }

    public function showw($fid,$id)
    {
          $topic = Topic::findOrFail($id);
          $auth = Auth::user();
        
          Answer::where('user_id', $auth->id)->where('topic_id', $topic->id)->delete();
          if ($auth) {
            // if ($answers = Answer::where('user_id', $auth->id)->get()) {
            //     $all_questions = collect();
            //     $q_filter = collect();
            //     foreach ($answers as $answer) {
            //       $q_id = $answer->question_id;
            //       $q_filter = $q_filter->push(Question::where('id', $q_id)->get());
            //     }
            //     $all_questions = $all_questions->push(Question::where('topic_id', $topic->id)->get());
            //     $all_questions = $all_questions->flatten();
            //     $q_filter = $q_filter->flatten();
            //     $questions = $all_questions->diff($q_filter);
            //     $questions = $questions->flatten();
            //     $questions = $questions->shuffle();
            //     return response()->json(["questions" => $questions, "auth"=>$auth, "topic" => $topic->id]);
            // }
            $dlevel = Session::get('dlevel');
            $questions = collect(); 
            $questions = Question::where('topic_id', $topic->id)->where('type',$dlevel)->get();
            $questions = $questions->flatten();
            $questions = $questions->shuffle();
            return response()->json(["questions" => $questions, "auth"=>$auth]);
          }
          return redirect('/');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return back()->with('deleted', 'Record has been deleted');
    }

    public function invite_friend(Request $request)
    {
        $Friend_invite = new Friend_invite();

        $dlevel = Session::get('dlevel');
        $topic_id = $request->topic_id;
        $friend_id = $request->friend_id;
        $user_id = Auth::user()->id;
        
        $Friend_inviteCheck = Friend_invite::where('user_id',$user_id)
                                ->where('friend_id',$friend_id)
                                ->where('topic_id',$topic_id)
                                ->where('level',$dlevel)
                                ->where('user_score',"-1")
                                ->where('friend_score',"-1")->first();
            
        if(count($Friend_inviteCheck)>0){
            $chat_id = $Friend_inviteCheck->id;
            Answer::where('user_id', $Friend_inviteCheck->friend_id)->where('topic_id', $Friend_inviteCheck->topic_id)->delete();
            Answer::where('user_id', $Friend_inviteCheck->user_id)->where('topic_id', $Friend_inviteCheck->topic_id)->delete();
        }else{
            $Friend_invite->user_id = $user_id;	
            $Friend_invite->friend_id = $friend_id;
            $Friend_invite->topic_id = $topic_id;
            $Friend_invite->level = $dlevel;
            $Friend_invite->user_score = "-1";
            $Friend_invite->friend_score = "-1";
            $Friend_invite->save();
    
            $chat_id = $Friend_invite->id;
        }
       Session::put('chat_id',$chat_id);
        $topic = Topic::findOrFail($topic_id);
        $successMsg = "Invite Send to Friend";
        $answers = Answer::where('topic_id','=',$topic->topic_id)->first();
        $chats_ob = Chat::where('chat_id',$chat_id);
        $update = $chats_ob->update(['status'=>1]);
        $chats = $chats_ob->get();
        return view('main_quiz', compact('topic','answers','chat_id','successMsg','chats'));
    }

    public function myinvites()
    {
        $Friend_invites = Friend_invite::where('friend_id',Auth::user()->id)
        ->where('user_score',"-1")
        ->where('friend_score',"-1")->get();
        // dd($Friend_invites[0],$Friend_invites[0]->user,$Friend_invites[0]->topic);
        return view('myinvites', compact('Friend_invites'));
    }

    public function sendedinvites()
    {
        $Friend_invites = Friend_invite::where('user_id',Auth::user()->id)
        ->where('user_score',"-1")
        ->where('friend_score',"-1")->get();
        // dd($Friend_invites[0],$Friend_invites[0]->user,$Friend_invites[0]->topic);
        return view('myinvites', compact('Friend_invites'));
    }

    
    public function joinquiz(Request $request)
    {
        $Friend_invite = Friend_invite::findOrFail($request->id);
        Session::put('dlevel',$Friend_invite->level);
        $topic_id = $Friend_invite->topic_id;
        $topic = Topic::findOrFail($topic_id);
        $chat_id = $request->id;
        Session::put('chat_id',$chat_id);
        $successMsg = "You Join the quiz Successfully, Best of luck";
        $answers = Answer::where('topic_id','=',$topic_id)->first();
        // dd($Friend_invite,$topic,$answers);
        $chats_ob = Chat::where('chat_id',$chat_id);
        $update = $chats_ob->update(['status'=>1]);
        $chats = $chats_ob->get();
        return view('main_quiz', compact('topic','answers','chat_id','successMsg','chats'));
    }
}
