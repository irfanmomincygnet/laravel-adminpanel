<?php

namespace App\Http\Responses\Frontend\Blog;

use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{
    protected $blogs;

    protected $search;

    public function __construct($blogs, $search)
    {
        $this->blogs = $blogs;
        $this->search = $search;
    }

    public function toResponse($request)
    {
        return view('frontend.blogs.index')->with(['blogs' => $this->blogs, 'search' => $this->search]);
    }
}
