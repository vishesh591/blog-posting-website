<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('dashboard.tags.index', [
            'tags' => Tag::withCount('blogs')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        Tag::updateOrCreate(
            ['slug' => Str::slug($request->name)],
            ['name' => $request->name, 'slug' => Str::slug($request->name)]
        );

        return back()->with('success', 'Tag saved successfully.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return back()->with('success', 'Tag deleted successfully.');
    }
}
