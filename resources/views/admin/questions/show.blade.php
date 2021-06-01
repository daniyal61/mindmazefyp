@extends('layouts.admin', [
  'page_header' => "Questions / {$topic->title} ",
  'dash' => '',
  'quiz' => '',
  'users' => '',
  'questions' => 'active',
  'top_re' => '',
  'all_re' => '',
  'sett' => ''
])

@section('content')
  <div class="margin-bottom">
    <button type="button" class="btn btn-wave" data-toggle="modal" data-target="#createModal">Add Question</button>
    <button type="button" class="btn btn-wave" data-toggle="modal" data-target="#importQuestions">Import Questions</button>
  </div>
  <!-- Create Modal -->
  <div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Question</h4>
        </div>
        {!! Form::open(['method' => 'POST', 'action' => 'QuestionsController@store', 'files' => true]) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                {!! Form::hidden('topic_id', $topic->id) !!}
                <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">                  
                  {!! Form::label('question', 'Question') !!}
                  <span class="required">*</span>
                  {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('question') }}</small>
                </div>
                <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                    {!! Form::label('answer', 'Correct Answer') !!}
                    <span class="required">*</span>
                    {!! Form::select('answer', array('A'=>'A', 'B'=>'B', 'C'=>'C', 'D'=>'D'),null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder'=>'']) !!}
                    <small class="text-danger">{{ $errors->first('answer') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
                  {!! Form::label('a', 'A - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('a') }}</small>
                </div>
                <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
                  {!! Form::label('b', 'B - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('b') }}</small>
                </div>
                <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                  {!! Form::label('c', 'C - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('c') }}</small>
                </div>
                <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                  {!! Form::label('d', 'D - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('d') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    {!! Form::label('type', 'Type') !!}
                    <span class="required">*</span>
                    {!! Form::select('type', array('easy'=>'Easy', 'medium'=>'Medium', 'hard'=>'Hard'),null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'']) !!}
                    <small class="text-danger">{{ $errors->first('type') }}</small>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default']) !!}
              {!! Form::submit("Add", ['class' => 'btn btn-wave']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- Import Questions Modal -->
  <div id="importQuestions" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Import Questions (Excel File With Exact Header of DataBase Field)</h4>
        </div>
        {!! Form::open(['method' => 'POST', 'action' => 'QuestionsController@importExcelToDB', 'files' => true]) !!}
          <div class="modal-body">
            {!! Form::hidden('topic_id', $topic->id) !!}
            <div class="form-group{{ $errors->has('question_file') ? ' has-error' : '' }}">
              {!! Form::label('question_file', 'Import Question Via Excel File', ['class' => 'col-sm-3 control-label']) !!}
              <span class="required">*</span>
              <div class="col-sm-9">
                {!! Form::file('question_file', ['required' => 'required']) !!}
                <p class="help-block">Only Excel File (.CSV and .XLS)</p>
                <small class="text-danger">{{ $errors->first('question_file') }}</small>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default']) !!}
              {!! Form::submit("Import", ['class' => 'btn btn-wave']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <div class="box">
    <div class="box-body table-responsive">
      <table id="questions_table" class="table table-hover table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Questions</th>
            <th>A - Option</th>
            <th>B - Option</th>
            <th>C - Option</th>
            <th>D - Option</th>
            <th>Type</th>
            <th>Correct Answer</th>
            <th>Code Snippet</th>
            <th>Answer Explanation</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if ($questions)
            @foreach ($questions as $key => $question)
              @php
                $answer = strtolower($question->answer);
              @endphp
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>{{$question->question}}</td>
                <td>{{$question->a}}</td>
                <td>{{$question->b}}</td>
                <td>{{$question->c}}</td>
                <td>{{$question->d}}</td>
                <td>{{$question->type}}</td>
                <td>{{$question->$answer}}</td>
                <td>
                  <pre>
                    {{{$question->code_snippet}}}
                  </pre>
                </td>
                <td>
                  {{$question->answer_exp}}
                </td>
                <td>
                  <img src="{{asset('/images/questions/'.$question->question_img)}}" class="img-responsive" alt="image">
                </td>
               
                <td>
                  <!-- Edit Button -->
                  <a type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#{{$question->id}}EditModal"><i class="fa fa-edit"></i> Edit</a>
                  <!-- Delete Button -->
                  <a type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{$question->id}}deleteModal"><i class="fa fa-close"></i> Delete</a>
                  <div id="{{$question->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                    <!-- Delete Modal -->
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                          <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          {!! Form::open(['method' => 'DELETE', 'action' => ['QuestionsController@destroy', $question->id]]) !!}
                            {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                            {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <!-- edit model -->
              <div id="{{$question->id}}EditModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Question</h4>
                    </div>
                    {!! Form::model($question, ['method' => 'PATCH', 'action' => ['QuestionsController@update', $question->id], 'files' => true]) !!}
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                              {!! Form::label('question', 'Question') !!}
                              <span class="required">*</span>
                              {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('question') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                {!! Form::label('answer', 'Correct Answer') !!}
                                <span class="required">*</span>
                                {!! Form::select('answer', array('A'=>'A', 'B'=>'B', 'C'=>'C', 'D'=>'D'),null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder'=>'']) !!}
                                <small class="text-danger">{{ $errors->first('answer') }}</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
                              {!! Form::label('a', 'A - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('a') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
                              {!! Form::label('b', 'B - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('b') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                              {!! Form::label('c', 'C - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('c') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('d', 'D - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                {!! Form::label('type', 'Type') !!}
                                <span class="required">*</span>
                                {!! Form::select('type', array('easy'=>'Easy', 'medium'=>'Medium', 'hard'=>'Hard'),null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'']) !!}
                                <small class="text-danger">{{ $errors->first('type') }}</small>
                            </div>
                          </div>
                         
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="btn-group pull-right">
                          {!! Form::submit("Update", ['class' => 'btn btn-wave']) !!}
                        </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection

