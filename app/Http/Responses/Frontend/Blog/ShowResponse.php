<?php

namespace App\Http\Responses\Frontend\Blog;

use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable
{
    protected $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    public function toResponse($request)
    {
        return view('frontend.blogs.show')->with(['blog' => $this->blog]);
    }
}
