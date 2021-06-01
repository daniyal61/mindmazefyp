@extends('layouts.app')

@section('head')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <script>
    window.Laravel =  <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
  </script>
  <style>
      body{ 
			background: url("{{asset('images/bg.jpg')}}");
		}
    </style>
@endsection



@section('content')
@if ($auth)
<div class="container">
    
    <div class="quiz-main-block">
      <div class="row">
        @if ($topics)
          @foreach ($topics as $topic)
            <div class="col-md-4">
              <div class="topic-block">
                <div class="card blue-grey darken-1">
                  <div class="card-content white-text">
                    <span class="card-title">{{$topic->title}}</span>
                    <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                    <div class="row">
                      <div class="col-xs-6 pad-0">
                        <ul class="topic-detail">
                          <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                          <li>Total Points <i class="fa fa-long-arrow-right"></i></li>
                          <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                          <li>Time Per Question <i class="fa fa-long-arrow-right"></i></li>
                          
                        </ul>
                      </div>
                      <div class="col-xs-6">
                        <ul class="topic-detail right">
                          <li>{{$topic->per_q_mark}}</li>
                          <li>
                            @php
                                $qu_count = App\Question::where('topic_id',$topic->id)->count();
                            @endphp
                           
                            {{$topic->per_q_mark*$qu_count}}
                          </li>
                          <li>
                            @php
                                
                            @endphp
                            {{$qu_count}}
                          </li>
                          <li>
                            {{$topic->timer}} seconds
                          </li>

                       
                        </ul>
                      </div>
                    </div>
                  </div>


               <div class="card-action text-center">
                  
                  @if (Session::has('added'))
                    <div class="alert alert-success sessionmodal">
                      {{session('added')}}
                    </div>
                  @elseif (Session::has('updated'))
                    <div class="alert alert-info sessionmodal">
                      {{session('updated')}}
                    </div>
                  @elseif (Session::has('deleted'))
                    <div class="alert alert-danger sessionmodal">
                      {{session('deleted')}}
                    </div>
                  @endif
                  <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>
                  <form action="{{ route('invite_friend') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}" />
                    @if(count($Friends)>0)
                    <select class="btn" name="friend_id" id="" >
                      
                      @foreach($Friends as $value)
                      <?php
                        $users = explode(',',$value->user_id);
                        $id = '';
                        if($users[0]==Auth::user()->id){
                          $id = $users[1];
                        }else{
                          $id = $users[0];
                        }
                        $friend = App\User::find($id);
                      ?>
                        <option value="{{$friend->id}}">{{$friend->name}} {{$friend->last_name}}</option>
                      @endforeach
                      
                    </select>
                    <button type="submit" class="btn" >Invite Friend</button>
                    @else
                      <a href="{{url('/admin/addfriend')}}" class="btn btn-block" title="Start Quiz">Add Friend</a>

                    @endif
                  </form>
                  
                    <!-- @if($auth->topic()->where('topic_id', $topic->id)->exists())
                      <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>

                    @else
                      {!! Form::open(['method' => 'POST', 'action' => 'PaypalController@paypal_post']) !!} 
                        {{ csrf_field() }}
                        <input type="hidden" name="topic_id" value="{{$topic->id}}"/>
                         @if(!empty($topic->amount)) 

                        <button type="submit" class="btn btn-default">Pay  <i class="{{$setting->currency_symbol}}"></i>{{$topic->amount}}</button>
                          @else 

                          <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>

                          <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Invite a friend</a>

                        @endif

                      {!! Form::close() !!}
                    @endif -->
                  </div>


                <!-- {{--   <div class="card-action">
                    @php 
                      $a = false;
                      $que_count = $topic->question ? $topic->question->count() : null;
                      $ans = $auth->answers;
                      $ans_count = $ans ? $ans->where('topic_id', $topic->id)->count() : null;
                      if($que_count && $ans_count && $que_count == $ans_count){
                        $a = true;
                      }
                    @endphp
                    <a href="{{$a ? url('start_quiz/'.$topic->id.'/finish') : route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz
                    </a>
                  </div> --}} -->
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
    </div>
  @endif
  @if (!$auth)
<div class="container" style="background-image: url('/quizgame/public/images/quiz-games.png');background-repeat: no-repeat;background-size: cover;width: 100%">
    <div class="row" style="margin-top: 520px">
        <div class="col-md-8 col-md-offset-2">
            <div class="home-main-block">
             
                <blockquote style="background-color: #fff;border-color: #fcd708">
                  Please <a href="{{ route('login') }}">Login</a> To Start Quiz >>>
                </blockquote>
            </div>
        </div>
    </div>
    </div>
  @endif



@endsection

@section('scripts')

<script>
   $( document ).ready(function() {
       $('.sessionmodal').addClass("active");
       setTimeout(function() {
           $('.sessionmodal').removeClass("active");
      }, 4500);
    });
</script>


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
