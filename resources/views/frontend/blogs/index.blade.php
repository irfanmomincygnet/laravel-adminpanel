@extends('frontend.layouts.app')

@section('content')
	<div class="row">
		<div class="form-blog-search col-md-6">
			<input class="form-control" placeholder="Search by Name, Category or Tag" type="search" value="{{ $search }}" name="search" />
		</div>
	</div>

	<div class="blog-list-main">
		@if (count($blogs) > 0)
			@include('frontend.blogs.list', ['blogs' => $blogs])
		@else
			<div class="blogs-list">
				No Blogs found!!
			</div>
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
						success: function(result) {
							if(result != '') {
								$('.blog-list-main').html(result.html);
							}
							if(result.isAjax == 1) {
								var obj = { Page: 1, Url: "<?php echo action('Frontend\Blogs\BlogsController@index') ?>" };
								history.pushState(obj, obj.Page, obj.Url);
							}
						}
					});
				}
			}, 600);
		});
	</script>
@endsection