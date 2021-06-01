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

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_achievement">
                Add Achievement
            </button>
        </div>
        <div id="add_achievement" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Achievement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('add.new.achievement') }}" method="POST">
                    <div class="modal-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" name="description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Level</label>
                                <input type="text" name="level" class="form-control">
                            </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <div class="box-body table-responsive">

        <table class="table table-striped table-hover">
            <thead class="info">
                <tr>
                    <th>#</th>
                    <th>Achievements</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Achievements as $key => $value)

                <tr>
                    <td>
                        {{$key+1}}

                    </td>
                    <td>
                        <h2>{{$value->title}}</h2>
                        <br>
                        <p>{{$value->description}}</p>
                        
                    </td>
                    <td>
                        {{$value->level}}
                    </td>
                    <td>
                        <a href="{{ route('delete.achievement',$value->id)}}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection