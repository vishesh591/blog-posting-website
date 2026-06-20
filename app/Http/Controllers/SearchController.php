<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(private readonly SearchService $search)
    {
    }

    public function index(Request $request): View
    {
        $query = (string) $request->string('q');

        return view('search.index', [
            'query' => $query,
            'results' => $query ? $this->search->global($query) : ['blogs' => collect(), 'categories' => collect(), 'tags' => collect()],
        ]);
    }

    public function suggestions(Request $request): JsonResponse
    {
        return response()->json($this->search->suggestions((string) $request->string('q')));
    }
}
