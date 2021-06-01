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
@endsection


@section('content')
<div class="container">
  @if ($auth)
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="home-main-block">

               

        @if($topic->show_ans==1)
        
         <div class="question-block">
            <h2 class="text-center main-block-heading">{{$topic->title}} ANSWER REPORT</h2>
            <table class="table table-bordered result-table">
              <thead>
                <tr>
                  <th>Question</th>                  
                  
                  <th style="color: green;">Correct Answer</th>
                  <th style="color: red;">Your Answer</th>
                  <th>Answer Explnation</th>
                </tr>
              </thead>
              <tbody>
                @php
                 $answers = App\Answer::where('topic_id',$topic->id)->where('user_id',Auth::user()->id)->get();
                @endphp             
               
                @php
                $x = $count_questions;               
                $y = 1;
                @endphp
                @foreach($answers as $key=> $a)
                
                  @if($a->user_answer != "0" && $topic->id == $a->topic_id)
                    <tr>
                      <td>{{ $a->question->question }}</td>
                      <td>{{ $a->answer }}</td>
                      <td>{{ $a->user_answer }}</td>
                      <td>{{ $a->question->answer_exp }}</td>
                    </tr>
                    @php                
                      $y++;
                      if($y > $x){                 
                        break;
                      }
                    @endphp
                  @endif
                @endforeach              
               
              </tbody>
            </table>
            
          </div>

          @endif



          <div class="question-block">
            <h2 class="text-center main-block-heading">{{$topic->title}} Result</h2>
            <table class="table table-bordered result-table">
              <thead>
                <tr>
                  <th>Total Questions</th>
                  <th>My Marks</th>
                  <th>Per Question Mark</th>
                  <th>Total Marks</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$count_questions}}</td>
                  <td>
                    @php
                      $mark = 0;
                      $correct = collect();
                    @endphp
                    @foreach ($answers as $answer)
                      @if ($answer->answer == $answer->user_answer)
                        @php
                        $mark++;
                        @endphp
                      @endif
                    @endforeach
                    @php
                      $correct = $mark*$topic->per_q_mark;
                    @endphp
                    {{$correct}}
                  </td>
                  <td>{{$topic->per_q_mark}}</td>
                  <td>@php $total_marks = $topic->per_q_mark*$count_questions  @endphp {{$total_marks}}</td>
                </tr>
              </tbody>
            </table>
            @php $per = $correct/$total_marks @endphp
            @if($per<0.7)
             <h2 class="text-center text-danger">Failed!</h2>
             <h6  class="text-center text-danger">70% Marks needed to pass quiz</h6>
             @else
             <h2 class="text-center text-success">Pass!</h2>
              @php
                $user = App\User::find(Auth::user()->id);
                if($user->level<=$topic->level){
                  $user->level = $topic->level + 1;
                $user->save();
                }
                
                
              @endphp 
            @endif
            

            @isset($friend_marks)

              @if($friend_marks!='-1')
                <h2 class="text-center text-primary">Your Friend Marks are: {{$friend_marks}}</h2>
                @else
                <h2 class="text-center text-primary">Your Friend didn't complete the test yet. Please refresh to get latest result.</h2>
              @endif

            @endisset
            <h2 class="text-center">Thank You!</h2>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function(){
      history.pushState(null, null, document.URL);
      window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
      });
    });
  </script>
@endsection
