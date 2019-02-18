<div class="panel panel-default">
	<div class="panel-heading">
		<h3>Blogs</h3>
	</div>
	<div class="blogs-list">
		@foreach ($blogs as $blog)
			<h4><a href="{{ action('Frontend\Blogs\BlogsController@show', ['id' => $blog->id]) }}">{{ $blog->name }}</a></h4>
			<span>{{ \Carbon\Carbon::parse($blog->publish_datetime)->format('d\t\h M Y')}}</span>
			<p><img width="40%" src="{{ Storage::url('public/img/blog/' . $blog->featured_image) }}"></p>
			<p>{!! str_limit($blog->content, 200) !!}<a href="{{ action('Frontend\Blogs\BlogsController@show', ['id' => $blog->id]) }}">read more</a></p>
		@endforeach
	</div>
</div>