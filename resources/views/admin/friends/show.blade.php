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
    <div class="box-body table-responsive">
      <table id="example1" class="table table-striped table-hover">
        <thead class="info">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($Friends as $key => $value)
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
              <tr>
                <td>
                  {{$key+1}}
                  
                </td>
                <td>
                  {{$friend->name}}  {{$friend->last_name}}
                </td>
                <td>{{$friend->email}} </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
