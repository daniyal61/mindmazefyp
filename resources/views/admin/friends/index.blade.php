@extends('layouts.admin', [
  'page_header' => "My Friends",
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
            <th>Add</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $value)
                
              <tr>
                <td>
                  {{$key+1}}
                  
                </td>
                <td>
                  {{$value->name}}  {{$value->last_name}}
                </td>
                <td>{{$value->email}}</td>
                <td> 
                    <form action="{{route('addpostfriend')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="id" value="{{$value->id}}">
                        <button type="submit" class="btn btn-success">Add Friend</button>
                    </form>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
