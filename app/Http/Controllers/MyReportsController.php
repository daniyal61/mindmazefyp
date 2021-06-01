<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Topic;
use App\Answer;
use App\Question;
use App\Friend;

class MyReportsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

          $topics = Topic::all();
          $questions = Question::all();
          return view('admin.my_reports.index', compact('topics', 'questions'));

        } else {
          return redirect('/');
        }
    }

    public function show($id) {

      if (Auth::check()) {

        $auth = Auth::user();
        $topic = Topic::findOrFail($id);
        $total_marks = Question::where('topic_id', $topic->id)->get()->count();
        $answers = Answer::where('user_id', $auth->id)->where('topic_id', $topic->id)->get();
        
        return view('admin.my_reports.show', compact('topic', 'answers', 'total_marks'));

      } else {
        return redirect('/');
      }


    }

    public function addpostfriend(Request $request){
      $preid1 = Auth::user()->id.','.$request->id;
      $preid2 = $request->id.','.Auth::user()->id;
      // dd($preid1,$preid2);
      $findFriend= Friend::where('user_id',$preid1)->orWhere('user_id',$preid2)->get();
      if(count($findFriend)>0){
        return redirect()->back()->with('success','Friend Already Added');
      }
      $Friend = new Friend();
      $Friend->user_id = Auth::user()->id.','.$request->id;
      $Friend->save();
      return redirect()->back()->with('success','Friend Added');
    }
}
