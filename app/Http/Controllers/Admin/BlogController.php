<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Notifications\BlogApprovedNotification;
use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Services\BlogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(
        private readonly BlogRepositoryInterface $blogs,
        private readonly BlogService $blogService,
    ) {
    }

    public function index(): View
    {
        return view('dashboard.blogs.index', [
            'blogs' => $this->blogs->paginateDashboard(auth()->user()->isAdmin() ? null : auth()->id()),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Blog::class);

        return view('dashboard.blogs.form', [
            'blog' => new Blog(),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $this->authorize('create', Blog::class);

        $blog = $this->blogService->create([
            ...$request->validated(),
            'author_id' => auth()->id(),
            'approved_by_id' => auth()->user()->isAdmin() ? auth()->id() : null,
        ]);

        if ($blog->status === 'review' && auth()->user()->isAdmin()) {
            $blog->author->notify(new BlogApprovedNotification($blog));
        }

        return redirect()->route('dashboard.blogs.edit', $blog)->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog): View
    {
        $this->authorize('update', $blog);

        return view('dashboard.blogs.form', [
            'blog' => $blog->load('tags'),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $this->authorize('update', $blog);

        $this->blogService->update($blog, [
            ...$request->validated(),
            'approved_by_id' => auth()->user()->isAdmin() ? auth()->id() : $blog->approved_by_id,
        ]);

        return back()->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->authorize('delete', $blog);

        $this->blogService->delete($blog);

        return back()->with('success', 'Blog deleted successfully.');
    }

    public function preview(Blog $blog): View
    {
        $this->authorize('view', $blog);

        return view('dashboard.blogs.preview', ['blog' => $blog->load(['author', 'category', 'tags'])]);
    }
}
