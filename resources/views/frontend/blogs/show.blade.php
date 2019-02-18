@extends('frontend.layouts.app')

@section('content')
	@if (count($blog) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>{{ $blog->name }}</h3>
			</div>
			<div class="panel-body">
				{!! $blog->content !!}
			</div>
		</div>
	@endif
@endsection