<?php

namespace App\Http\Controllers\Frontend\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Blogs\ManageBlogsRequest;
use App\Http\Requests\Backend\Blogs\StoreBlogsRequest;
use App\Http\Requests\Backend\Blogs\UpdateBlogsRequest;
use App\Http\Responses\Backend\Blog\CreateResponse;
use App\Http\Responses\Backend\Blog\EditResponse;
use App\Http\Responses\Frontend\Blog\IndexResponse;
use App\Http\Responses\Frontend\Blog\ShowResponse;
use App\Http\Responses\RedirectResponse;
use App\Models\BlogCategories\BlogCategory;
use App\Models\Blogs\Blog;
use App\Models\BlogTags\BlogTag;
use Illuminate\Support\Facades\DB;
use App\Repositories\Backend\Blogs\BlogsRepository;

/**
 * Class BlogsController.
 */
class BlogsController extends Controller
{
    /**
     * @var BlogsRepository
     */
    protected $blog;

    /**
     * @param \App\Repositories\Backend\Blogs\BlogsRepository $blog
     */
    public function __construct(BlogsRepository $blog)
    {
        $this->blog = $blog;
    }

    /**
     * @param \App\Http\Requests\Backend\Blogs\ManageBlogsRequest $request
     *
     * @return \App\Http\Responses\Backend\Blog\IndexResponse
     */
    public function index(ManageBlogsRequest $request)
    {
        $search = $request->get('search', $request->session()->get('blog_search', ''));
        if($search) {
            $request->session()->put('blog_search', $search);
            $catids = DB::table('blog_categories')
                ->select('blog_categories.id as categoryids')
                ->where('blog_categories.name', 'LIKE', '%' . $search . '%')
                ->get(['categoryids'])->toArray();

            $catidsArr = $tagidsArr = [];

            if($catids) {
                $catidsArr  = array_column($catids, 'categoryids');
            }

            $tagids = DB::table('blog_tags')
                ->select('blog_tags.id as tagids')
                ->where('blog_tags.name', 'LIKE', '%' . $search . '%')
                ->get(['tagids'])->toArray();

            if($tagids) {
                $tagidsArr  = array_column($tagids, 'tagids');
            }

            $blogs = Blog::join('blog_map_categories', 'blogs.id', '=', 'blog_map_categories.blog_id')->join('blog_map_tags', 'blogs.id', '=', 'blog_map_tags.blog_id')
                ->select('blogs.*')
                ->whereIn('blog_map_categories.category_id', $catidsArr)
                ->orWhereIn('blog_map_tags.tag_id', $tagidsArr)
                ->orWhere('blogs.name', 'LIKE', '%' . $search . '%')
                ->groupBy('blogs.id')
                ->get();
        }
        else {
            $blogs = Blog::all();
        }

        if($request->ajax()){
            if(count($blogs) <= 0) {
                return response()->json(['html' => 'No Result Found!']);
            }

            $returnHTML = view('frontend.blogs.list')->with('blogs', $blogs)->render();
            return response()->json(['html' => $returnHTML, 'search' => $search]);
        }

        return new IndexResponse($blogs, $search);
    }

    /**
     * @param \App\Http\Requests\Backend\Blogs\ManageBlogsRequest $request
     *
     * @return \App\Http\Responses\Backend\Blog\IndexResponse
     */
    public function show($blogId, ManageBlogsRequest $request)
    {
        $blog = Blog::findOrfail($blogId);

        return new ShowResponse($blog);
    }

    public function search()
    {
        echo "<pre/>";print_r("dfsfs");exit;
        $blog = Blog::findOrfail($blogId);

        return new ShowResponse($blog);
    }

    /**
     * @param \App\Http\Requests\Backend\Blogs\ManageBlogsRequest $request
     *
     * @return mixed
     */
    public function create(ManageBlogsRequest $request)
    {
        $blogTags = BlogTag::getSelectData();
        $blogCategories = BlogCategory::getSelectData();

        return new CreateResponse($this->status, $blogCategories, $blogTags);
    }

    /**
     * @param \App\Http\Requests\Backend\Blogs\StoreBlogsRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreBlogsRequest $request)
    {
        $this->blog->create($request->except('_token'));

        return new RedirectResponse(route('admin.blogs.index'), ['flash_success' => trans('alerts.backend.blogs.created')]);
    }

    /**
     * @param \App\Models\Blogs\Blog                              $blog
     * @param \App\Http\Requests\Backend\Blogs\ManageBlogsRequest $request
     *
     * @return \App\Http\Responses\Backend\Blog\EditResponse
     */
    public function edit(Blog $blog, ManageBlogsRequest $request)
    {
        $blogCategories = BlogCategory::getSelectData();
        $blogTags = BlogTag::getSelectData();

        return new EditResponse($blog, $this->status, $blogCategories, $blogTags);
    }

    /**
     * @param \App\Models\Blogs\Blog                              $blog
     * @param \App\Http\Requests\Backend\Blogs\UpdateBlogsRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Blog $blog, UpdateBlogsRequest $request)
    {
        $input = $request->all();

        $this->blog->update($blog, $request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.blogs.index'), ['flash_success' => trans('alerts.backend.blogs.updated')]);
    }

    /**
     * @param \App\Models\Blogs\Blog                              $blog
     * @param \App\Http\Requests\Backend\Blogs\ManageBlogsRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Blog $blog, ManageBlogsRequest $request)
    {
        $this->blog->delete($blog);

        return new RedirectResponse(route('admin.blogs.index'), ['flash_success' => trans('alerts.backend.blogs.deleted')]);
    }
}
