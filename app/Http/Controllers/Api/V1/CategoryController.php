<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\CategoryCollection;
use Illuminate\Http\Request;
use App\Filters\V1\CategoriesFilter;
use App\Policies\V1\CategoryPolicy;


class CategoryController extends Controller
{
    
    /**
     * Retrieves a listing of resources
     */
    public function index(Request $request)
    {
        $filter = new CategoriesFilter();
        $queryItems = $filter->transform($request);
        $categories = Category::where([
            ...$queryItems,
            'user_id' => $request->user()->id
        ])->paginate();
        return new CategoryCollection($categories->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Category::create([
            ...$request->all(),
            'user_id' => $request->user()->id
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category)
    {
        if($request->user()->cannot('show', [$category, CategoryPolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update([
            ...$request->all(),
            'user_id' => $request->user()->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        if($request->user()->cannot('delete', [$category, CategoryPolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category->delete();
    }
}
