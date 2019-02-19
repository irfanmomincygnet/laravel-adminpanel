<?php

namespace App\Http\Responses\Frontend\Blog;

use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{
    /**
     * Blogs list Object
     * @var Object
     */
    protected $blogs;

    /**
     * Search Value
     * @var String
     */
    protected $search;

    /**
     * Contstruct
     * @param Object $blogs  Blogs list
     * @param String $search Search Value
     */
    public function __construct($blogs, $search)
    {
        $this->blogs  = $blogs;
        $this->search = $search;
    }

    /**
     * Prepare response to send to template
     * @param  Object $request Request parameters
     * @return Object Blogs list
     */
    public function toResponse($request)
    {
        return view('frontend.blogs.index')->with(['blogs' => $this->blogs, 'search' => $this->search]);
    }
}
