<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly BlogRepositoryInterface $blogs,
        private readonly CategoryRepositoryInterface $categories,
        private readonly UserRepositoryInterface $users,
    ) {
    }

    public function index(): View
    {
        return view('home.index', [
            'featuredBlogs' => $this->blogs->featured(),
            'trendingBlogs' => $this->blogs->trending(),
            'recentBlogs' => $this->blogs->recent(),
            'popularBlogs' => $this->blogs->popular(),
            'categories' => $this->categories->all(),
            'popularAuthors' => $this->users->popularAuthors(),
        ]);
    }

    public function about(): View
    {
        return view('home.about');
    }

    public function contact(): View
    {
        return view('home.contact');
    }

    public function sendContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return back()->with('success', 'Thanks for reaching out. We will get back to you shortly.');
    }
}
