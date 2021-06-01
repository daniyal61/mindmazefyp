<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Chat;
use Auth;
use App\Friend_invite;
use App\Answer;
class ChatController extends Controller
{
    public function sendmessage(Request $request)
    {
        $chat_id = $request->chat_id;
        $message = $request->message;
        $sender_id = Auth::user()->id;
        $chat = new Chat();
        
        $chat->sender_id = $sender_id;
        $chat->message = $message;
        $chat->chat_id = $chat_id;
        $chat->save();

        $div = view('sendmsg',compact('message'))->render();
        return response()->json(
            [
                $div
            ]
        );
    }

    public function refreshchat(Request $request)
    {
        $chat_id = $request->chat_id;

        $chats_ob = Chat::where('chat_id',$chat_id)->where('status',0)->where('sender_id','!=',Auth::user()->id);
        $chats = $chats_ob->get();
        $update = $chats_ob->update(['status'=>1]);
        $div = '';
        foreach($chats as $chat){
            $message = $chat->message;
            $div .= view('recievemsg',compact('message'))->render();
        }
        return response()->json(
            $div
        );
    }

    public function refresquestion(Request $request)
    {
        $chat_id = $request->chat_id;
        $Friend_invite = Friend_invite::find($chat_id);

        $friend_id = $Friend_invite->friend_id;
        if(auth()->user()->id== $friend_id){
            $friend_id = $Friend_invite->user_id;
        }
        $topic_id = $Friend_invite->topic_id;

        $Answer = Answer::where('topic_id' ,$topic_id)->where('user_id' , $friend_id)->get() ;

        return response()->json(
            count( $Answer )
        );
        
    }
 

    
}
