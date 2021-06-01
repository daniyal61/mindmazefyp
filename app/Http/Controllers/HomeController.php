<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Question;
use App\Friend;
use App\Achievement;
use Session;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
      public function index2(Request $request)
    {
        // dd($request);
        $level = $request->level;
        $Friends = Friend::whereRaw('FIND_IN_SET(?,user_id)', [Auth::user()->id])->get();
        $dlevel = $request->dlevel;
        Session::put('dlevel',$dlevel );
        $topics    = Topic::where('level', $level)->get();

        // $questions = Question::all();

         return view('home', compact('topics', 'dlevel','Friends'));
    }


    public function user_achievements()
    {
        $Achievements = Achievement::where('level',auth()->user()->level)->get();
        return view('achievement',compact('Achievements'));
    }

    public function admin_achievements()
    {
        $Achievements = Achievement::all();
        return view('admin.achievement', compact('Achievements'));
    }

    public function addnewachievement(Request $request)
    {
        $Achievement = new Achievement();

        $Achievement->title = $request->title;
        $Achievement->description = $request->description;
        $Achievement->level = $request->level;
        $Achievement->save();

        return back()->with('updated', 'New Achievement Added!');
    }

    public function delete_achievement($id)
    {
        Achievement::findOrFail($id)->delete();
        return back()->with('updated', 'Achievement Deleted!');
    }
}
