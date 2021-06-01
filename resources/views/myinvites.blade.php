@extends('layouts.admin', [
  'page_header' => "Invites",
  'dash' => '',
  'users' => '',
  'questions' => '',
  'answers' => '',
  'top_re' => '',
  'all_re' => '',
  'sett' => ''
])

@section('content')
  <div class="content-block box">
     

      @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    <div class="box-body table-responsive">
      <table id="example1" class="table table-striped table-hover">
        <thead class="info">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Topic</th>
            <th>Level</th>
            <th>Difficulty Level</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($Friend_invites as $key => $value)
                
              <tr>
                <td>
                  {{$key+1}}
                  
                </td>
                <td>
                  {{$value->user->name}}  {{$value->user->last_name}}
                </td>
                <td>{{$value->user->email}}</td>
                <td>{{$value->topic->title}}</td>
                <td>{{$value->topic->level}}</td>
                <td>{{$value->level}}</td>
                <td> 
                    <form action="{{route('joinquiz')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="id" value="{{$value->id}}">
                        <button type="submit" class="btn btn-success">Join Quiz</button>
                    </form>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
