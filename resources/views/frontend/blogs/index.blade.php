@extends('frontend.layouts.app')

@section('content')
	<div class="form-blog-search">
		<input type="search" value="{{ $search }}" name="search" />
	</div>

	<div class="blog-list-main">
		@if (count($blogs) > 0)
			@include('frontend.blogs.list', ['blogs' => $blogs])
		@endif
	</div>
@endsection

@section('after-scripts')
	<script>
		$('input[type="search"]').keyup(function(e){
			e.preventDefault();
			e.stopImmediatePropagation();
			setTimeout(function() {
				var search = $('input[type="search"]').val();

				if(search.length >= 3 || search.length == 0) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
						}
					});

					$.ajax({
						url: "<?php echo action('Frontend\Blogs\BlogsController@index') ?>",
						method: 'GET',
						data: {
							search: search
						},
						success: function(result){
							if(result != '') {
								$('.blog-list-main').html(result.html);
							}
						}
					});
				}
			}, 600);
		});
	</script>
@endsection


