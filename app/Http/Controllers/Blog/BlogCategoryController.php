<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class BlogCategoryController extends Controller

{
    use CustomResponse, CheckRole;
    public function index()
    {
        $this->checkRole(['admin']);
        try {

            $data = BlogCategory::all();

            return $this->create_response('All categories', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }



    public function store(BlogCategoryRequest $request)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            $data = BlogCategory::create($valid);
            return $this->create_response('Added category', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(BlogCategoryRequest $request, BlogCategory $blog_category)
    {
        $this->checkRole(['admin']);

        try {
            $valid = $request->validated();

            $blog_category->update($valid);
            $data = $blog_category;
            return $this->create_response('Updated category', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(BlogCategory $blog_category)


    {
        $this->checkRole(['admin']);
        try {
            $data = $blog_category;
            $blog_category->delete();
            return $this->create_response('Deleted category', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
