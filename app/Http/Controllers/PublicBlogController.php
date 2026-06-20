<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PublicBlogController extends Controller
{
    public function __construct(
        private readonly BlogRepositoryInterface $blogs,
        private readonly CategoryRepositoryInterface $categories,
        private readonly TagRepositoryInterface $tags,
        private readonly UserRepositoryInterface $users,
    ) {
    }

    public function index(Request $request): View
    {
        return view('blogs.index', [
            'blogs' => $this->blogs->paginatePublic($request->only(['search', 'category', 'tag'])),
            'categories' => $this->categories->all(),
            'tags' => $this->tags->all(),
            'filters' => $request->only(['search', 'category', 'tag']),
        ]);
    }

    public function show(string $slug): View
    {
        $blog = $this->blogs->findBySlug($slug);
        $blog->increment('views_count');

        if (auth()->check()) {
            DB::table('reading_histories')->updateOrInsert(
                ['blog_id' => $blog->id, 'user_id' => auth()->id()],
                ['last_read_at' => now(), 'progress_percentage' => 15, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return view('blogs.show', [
            'blog' => $blog->load(['comments.replies', 'comments.user']),
            'relatedBlogs' => $this->blogs->related($blog),
        ]);
    }

    public function author(int $author): View
    {
        $authorProfile = $this->users->findAuthorById($author);

        return view('blogs.author', [
            'authorProfile' => $authorProfile,
        ]);
    }

    public function category(string $slug): View
    {
        return view('blogs.taxonomy', [
            'title' => 'Category',
            'slug' => $slug,
            'blogs' => $this->blogs->paginatePublic(['category' => $slug]),
        ]);
    }

    public function tag(string $slug): View
    {
        return view('blogs.taxonomy', [
            'title' => 'Tag',
            'slug' => $slug,
            'blogs' => $this->blogs->paginatePublic(['tag' => $slug]),
        ]);
    }
}
