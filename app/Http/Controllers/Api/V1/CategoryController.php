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


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CategoriesFilter();
        $queryItems = $filter->transform($request);
        $categories = Category::where($queryItems)->paginate();
        return new CategoryCollection($categories->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Category::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
