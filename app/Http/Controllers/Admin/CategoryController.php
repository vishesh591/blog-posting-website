<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('dashboard.categories.index', [
            'categories' => Category::withCount('blogs')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::updateOrCreate(
            ['slug' => Str::slug($request->name)],
            [...$request->validated(), 'slug' => Str::slug($request->name), 'color' => $request->color ?: '#0f172a']
        );

        return back()->with('success', 'Category saved successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
