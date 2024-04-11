<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class CategoryController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()
    {
        $this->checkRole(['admin']);
        try {

            $data = Category::all();

            return $this->create_response('All categories', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }



    public function store(StoreCategoryRequest $request)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            $data = Category::create($valid);
            return $this->create_response('Added category', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();
            $category->update($valid);
            $data = $category;
            return $this->create_response('Updated category', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Category $category)


    {
        $this->checkRole(['admin']);
        try {
            $data = $category;
            $category->delete();
            return $this->create_response('Deleted category', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
