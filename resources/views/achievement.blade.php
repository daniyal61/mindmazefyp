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
        <table class="table table-striped table-hover">
            <thead class="info">
                <tr>
                    <th>#</th>
                    <th>Achievements</th>
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
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection