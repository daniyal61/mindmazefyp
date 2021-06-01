

<div class="">
<h3 class=" text-center">Chat</h3>
    <div class="messaging">
      <div class="inbox_msg">
        <div class="mesgs">
            <div id="msg_history" class="msg_history">
                @isset($chats)
                    @foreach($chats as $chat)
                        @if(Auth::user()->id==$chat->sender_id)
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p>{{$chat->message}}</p>
                                </div>
                            </div>
                        @else
                            <div class="incoming_msg">
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                    <p>{{$chat->message}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endisset
                
                
            </div>
          <div class="type_msg">
            <div class="input_msg_write">
                <input type="hidden" id="chat_id" name="chat_id" value="{{$chat_id}}">
                <input type="text" id="messagetext" class="write_msg" name="message" placeholder="Type a message" />
              <button id="sendbutton" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>