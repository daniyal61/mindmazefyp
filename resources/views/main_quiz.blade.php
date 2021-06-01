@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script>
    window.Laravel =  <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
  </script>
  <style>
    .container{max-width:1170px; margin:auto;}
    img{ max-width:100%;}
    .inbox_people {
    background: #f8f8f8 none repeat scroll 0 0;
    float: left;
    overflow: hidden;
    width: 40%; border-right:1px solid #c4c4c4;
    }
    .inbox_msg {
    border: 1px solid #c4c4c4;
    clear: both;
    overflow: hidden;
    }
    .top_spac{ margin: 20px 0 0;}


    .recent_heading {float: left; width:40%;}
    .srch_bar {
    display: inline-block;
    text-align: right;
    width: 60%;
    }
    .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

    .recent_heading h4 {
    color: #05728f;
    font-size: 21px;
    margin: auto;
    }
    .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
    .srch_bar .input-group-addon button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
    color: #707070;
    font-size: 18px;
    }
    .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

    .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
    .chat_ib h5 span{ font-size:13px; float:right;}
    .chat_ib p{ font-size:14px; color:#989898; margin:auto}
    .chat_img {
    float: left;
    width: 11%;
    }
    .chat_ib {
    float: left;
    padding: 0 0 0 15px;
    width: 88%;
    }

    .chat_people{ overflow:hidden; clear:both;}
    .chat_list {
    border-bottom: 1px solid #c4c4c4;
    margin: 0;
    padding: 18px 16px 10px;
    }
    .inbox_chat { height: 550px; overflow-y: scroll;}

    .active_chat{ background:#ebebeb;}

    .incoming_msg_img {
    display: inline-block;
    width: 6%;
    }
    .received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
    }
    .received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 3px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
    }
    .time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
    }
    .received_withd_msg { width: 57%;    margin-bottom: 10px;}
    .mesgs {
    float: left;
    padding: 30px 15px 0 25px;
    width: 100%;
    }

    .sent_msg p {
    background: #05728f none repeat scroll 0 0;
    border-radius: 3px;
    font-size: 14px;
    margin: 0; color:#fff;
    padding: 5px 10px 5px 12px;
    width:100%;
    }
    .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
    .sent_msg {
    float: right;
    width: 46%;
    }
    .input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
    }

    .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
    .msg_send_btn {
    background: #05728f none repeat scroll 0 0;
    border: medium none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
    }
    .messaging { padding: 0 0 50px 0;}
    .msg_history {
    height: 516px;
    overflow-y: auto;
    }
    .countdown{
        background: antiquewhite;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        text-align: center;
        position: fixed;
        left: 45%;
        right: 45%;
    }
    .countdown span{
        font-size: 40px;
    }
</style>
@endsection



@section('content')
 
<div class="container">
  @isset($successMsg)
    <div class="alert alert-success">
        {{ $successMsg }}
    </div>
  @endisset
  @if ($auth)
    @isset($chat_id)
        <div>
            Your Firend is at question number <span id="firend_question"></span><br>
        </div>
    @endisset
    <div class="countdown">
        <span id="countdown">{{$topic->timer}}</span><p>sec</p>    
    </div>
    <div class="home-main-block col-md-6">
      <?php $users =  '';
       $que =  App\Question::where('topic_id',$topic->id)->first();
      ?>
       @if(!empty($users))
           <!-- <div id="question_block" class="question-block">
        <question :topic_id="{{$topic->id}}" ></question>
      </div> -->
      <div class="alert alert-danger">
              You have already Given the test ! Try to give other Quizes
      </div>
       @else
      <div id="question_block" class="question-block">
        <question :topic_id="{{$topic->id}}" ></question>
      </div>
      @endif
      @if(empty($que))
      <div class="alert alert-danger">
            No Questions in this quiz
      </div>
      @else
      
      @endif
    </div>
    @isset($chat_id)
    <div class="col-md-6">@include('chats')</div>
    @endisset
  @endif
</div>
@endsection

@section('scripts')
  <!-- jQuery 3 -->
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/jquery.cookie.js')}}"></script>
  <script src="{{asset('js/jquery.countdown.js')}}"></script>
  <script>
    setInterval(function(){
        var time = parseInt($('#countdown').html());
        console.log('asdas'+time);
        if(time > 0){
            $('#countdown').html(parseInt(time - 1));
        }
    },1000);
  </script>
@isset($chat_id)
<script>
    setInterval(function(){
        refresChat("{{$chat_id}}");
        console.log("{{$chat_id}}")
    },2000);


    

    setInterval(function(){
    refresquestion("{{$chat_id}}");
    console.log("{{$chat_id}}")
    },2000);

    function refresquestion(chat_id){
    $.ajax({
    url: "{{route('refresquestion')}}",
    data:{
    chat_id: $('#chat_id').val()
    },
    success: function(result){
        $('#firend_question').empty();
    $('#firend_question').append(result);
    console.log(result);
    if(result){
    scrollbottom("msg_history");
    }
    
    },
    error: function(error){
    console.log(error);
    }
    });
    }
    function refresChat(chat_id){
        $.ajax({
        url: "{{route('refreshchat')}}", 
        data:{
            chat_id: $('#chat_id').val()
        },
        success: function(result){
            $('#msg_history').append(result);
            console.log(result);
            if(result){
                scrollbottom("msg_history");
            }
            
        },
        error: function(error){
            console.log(error);
        }
    });
    }
    function scrollbottom(id){
        var objDiv = document.getElementById(id);
        objDiv.scrollTop = objDiv.scrollHeight;
    }
</script>
@endisset
<script>
$(document).ready(function(){
  $("#sendbutton").click(function(){
    message = $('#messagetext').val();
    chat_id = $('#chat_id').val();
    if(message == '' || chat_id == ''){
        return;
    }
    console.log([message,chat_id]);
    $.ajax({
        url: "{{route('sendmessage')}}", 
        data:{
            message: $('#messagetext').val(),
            chat_id: $('#chat_id').val()
        },
        success: function(result){
            $('#msg_history').append(result);
            console.log(result);
            $('#messagetext').val("");
            scrollbottom("msg_history");
        },
        error: function(error){
            console.log(error);
        }
    });
  });

  
});

</script>
  @if(empty($users) && !empty($que))
   <script>
    var topic_id = {{$topic->id}};
    var timer = ({{$topic->timer}}*1000);
    setInterval(function(){

        $(".myQuestion").each(function(){
            if($(this).hasClass("active")){
                var button = $(this).find('button');
                // console.log(button);
                button.click();
            }
            
        });
      
        // $('.nextbtn').click();
        console.log("NEXT QUESTION TIME OUT");
    },timer);

    
    
    console.log('time :'+timer);
     $(document).ready(function() {
      function e(e) {
          (116 == (e.which || e.keyCode) || 82 == (e.which || e.keyCode)) && e.preventDefault()
      }
      setTimeout(function() {
          $(".myQuestion:first-child").addClass("active");
          $(".prebtn").attr("disabled", true); 
      }, 2500), history.pushState(null, null, document.URL), window.addEventListener("popstate", function() {
          history.pushState(null, null, document.URL)
      }), $(document).on("keydown", e), setTimeout(function() {
          $(".nextbtn").click(function() {
              var e = $(".myQuestion.active");
              $(e).removeClass("active"), 0 == $(e).next().length ? (Cookies.remove("time"), Cookies.set("done", "Your Quiz is Over...!", {
                  expires: 1
              }), location.href = "{{$topic->id}}/finish") : ($(e).next().addClass("active"), $(".myForm")[0].reset(),
              $(".prebtn").attr("disabled", false))
          }),
          $(".prebtn").click(function() {  
              var e = $(".myQuestion.active");
              $(e).removeClass("active"),
              $(e).prev().addClass("active"), $(".myForm")[0].reset()
              $(".myQuestion:first-child").hasClass("active") ?  $(".prebtn").attr("disabled", true) :   $(".prebtn").attr("disabled", false);
          })
      }, 700);
      var i, o = (new Date).getTime() + 1000 * timer;
      if (Cookies.get("time") && Cookies.get("topic_id") == topic_id) {
          i = Cookies.get("time");
          var t = o - i,
              n = o - t;
          $("#clock").countdown(n, {
              elapse: !0
          }).on("update.countdown", function(e) {
              var i = $(this);
              e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                  expires: 1
              }), Cookies.remove("time"), location.href = "{{$topic->id}}/finish") : i.html(e.strftime("<span>%H:%M:%S</span>"))
          })
      } else Cookies.set("time", o, {
          expires: 1
      }), Cookies.set("topic_id", topic_id, {
          expires: 1
      }), $("#clock").countdown(o, {
          elapse: !0
      }).on("update.countdown", function(e) {
          var i = $(this);
          e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
              expires: 1
          }), Cookies.remove("time"), location.href = "{{$topic->id}}/finish") : i.html(e.strftime("<span>%H:%M:%S</span>"))
      })
  });
  </script>
  @else
  {{ "" }}
  @endif

  
 @if($setting->right_setting == 1)
  <script type="text/javascript" language="javascript">
   // Right click disable
    $(function() {
    $(this).bind("contextmenu", function(inspect) {
    inspect.preventDefault();
    });
    });
      // End Right click disable
  </script>
@endif

@if($setting->element_setting == 1)
<script type="text/javascript" language="javascript">
//all controller is disable
      $(function() {
      var isCtrl = false;
      document.onkeyup=function(e){
      if(e.which == 17) isCtrl=false;
}

      document.onkeydown=function(e){
       if(e.which == 17) isCtrl=true;
      if(e.which == 85 && isCtrl == true) {
     return false;
    }
 };
      $(document).keydown(function (event) {
       if (event.keyCode == 123) { // Prevent F12
       return false;
  }
      else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
     return false;
   }
 });
});
     // end all controller is disable
 </script>


@endif
@endsection
