<?php

namespace App\Http\Controllers\Frontend\Blogs;

use App\Models\Blogs\Blog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Responses\Frontend\Blog\ShowResponse;
use App\Http\Responses\Frontend\Blog\IndexResponse;
use App\Http\Requests\Frontend\Blogs\ManageBlogsRequest;

/**
 * Class BlogsController.
 */
class BlogsController extends Controller
{
    /**
     * @param \App\Http\Requests\Frontend\Blogs\ManageBlogsRequest $request
     *
     * @return \App\Http\Responses\Frontend\Blog\IndexResponse
     */
    public function index(ManageBlogsRequest $request)
    {
        $search = $request->get('search', $request->session()->get('blog_search', ''));

        $request->session()->put('blog_search', $search);

        if($search != '') {
            $catidsArr = DB::table('blog_categories')
                ->select('blog_categories.id as categoryids')
                ->where('blog_categories.name', 'LIKE', '%' . $search . '%')
                ->pluck('categoryids')->toArray();

            $tagidsArr = DB::table('blog_tags')
                ->select('blog_tags.id as tagids')
                ->where('blog_tags.name', 'LIKE', '%' . $search . '%')
                ->pluck('tagids')->toArray();

            $blogs = Blog::join('blog_map_categories', 'blogs.id', '=', 'blog_map_categories.blog_id')->join('blog_map_tags', 'blogs.id', '=', 'blog_map_tags.blog_id')
                ->select('blogs.*')
                ->whereIn('blog_map_categories.category_id', $catidsArr)
                ->orWhereIn('blog_map_tags.tag_id', $tagidsArr)
                ->orWhere('blogs.name', 'LIKE', '%'.$search.'%')
                ->groupBy('blogs.id')
                ->paginate(Blog::$perpage);
        }
        else {
            $blogs = Blog::paginate(Blog::$perpage);
        }

        if($request->ajax()){
            if(count($blogs) <= 0) {
                return response()->json(['html' => 'No Blogs found!!']);
            }

            $returnHTML = view('frontend.blogs.list')->with('blogs', $blogs)->render();
            return response()->json(['html' => $returnHTML, 'search' => $search, 'isAjax' => true]);
        }

        return new IndexResponse($blogs, $search);
    }

    /**
     * @param \App\Http\Requests\Frontend\Blogs\ManageBlogsRequest $request
     *
     * @return \App\Http\Responses\Frontend\Blog\IndexResponse
     */
    public function show($blogId, ManageBlogsRequest $request)
    {
        $blog = Blog::findOrfail($blogId);

        return new ShowResponse($blog);
    }
}
