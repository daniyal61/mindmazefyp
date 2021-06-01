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
  <style type="text/css">
		body{ 
			background: url("{{asset('images/bg.jpg')}}");
		}
		.maintop{
			margin-top: 100px
		}
		.subtop{
			margin-top: 50px;
		}
		.select-level{
			cursor: pointer;
		}
		.dlevel {
			display:none;
			margin-top: 10%;
		}
		.dlevel span{
			font-size:30px;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
			height: 300px;
			cursor: pointer;
			background: #b2d1e8;
    		border-radius: 20px;
		}
		.dlevel input{
			display:none;
		}
		.dlevel img{
			cursor: pointer;
		}
		.level-image {
			text-align:center;
			margin-bottom: 15px;
		}
		.level-image span{
			text-align:center;
			font-size: 50px;
			position: absolute;
			bottom: 8px;
			left: 45%;
			color: white;
		}
		.level-image img{
			width: 150px;
			height: 170px;
		}
	</style>
@endsection


@section('content')
<div class="container">
	<div class="row maintop" id="level-div">
		@php $level = Auth::user()->level; @endphp
		@for($i=1; $i<=12; $i++)
		<div class="col-md-3 level-image col-sm-12">
			@if($i<=$level)
				<img class="select-level" data-value="{{$i}}" src="{{asset('images/unlocked.png')}}">
				<span>{{$i}}</span>
			@else
				<img src="{{asset('images/locked.png')}}">
			@endif
		</div>
		@endfor
	</div>
	<div class="dlevel row" id="dlevel-div">
		<form id="form-select-level" action="{{route('level.screen')}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" id="level-input" name="level">
			<label class="col-sm-4 " for="easy">
				<img src="{{asset('images/easy.png')}}">
				<input class="select-dlevel" type="radio" name="dlevel" value="easy" id="easy">
			</label>

			<label class="col-sm-4 " for="medium">
				<img src="{{asset('images/medium.png')}}">
				<input class="select-dlevel" type="radio" name="dlevel" value="medium" id="medium">
			</label>

			<label class="col-sm-4 " for="hard">
				<img src="{{asset('images/hard.png')}}">
				<input class="select-dlevel" type="radio" name="dlevel" value="hard" id="hard">
			</label>
		</form>
	</div>
</div>
@endsection

@section('scripts')
	<script>
		$('.select-level').on('click tap',function(){
			level= $(this).attr('data-value');
			$('#level-input').val(level)
			$('#level-div').hide()
			$('#dlevel-div').show()
			console.log(level);
		});
		$('.select-dlevel').on('click tap',function(){
			level= $(this).val();
			$('#form-select-level').submit();
			console.log(level);
		});
		
	</script>
@endsection
