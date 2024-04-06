<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return $categories;
    }


    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        return Category::create($data);
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $data = $request->validated();
        return $category->update($data);
    }

    public function destroy(Category $category)
    {
        return $category->delete();
    }
}
