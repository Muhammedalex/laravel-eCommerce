<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    use CustomResponse, CheckRole;

    public function index()
    {
        try {

            $blogs = Blog::with('blog_category', 'blog_likes')
                ->paginate(10);
            $data = $blogs;
            return $this->create_response('all blogs', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }



    public function show(Blog $blog)
    {
        try {

            $blog = Blog::with('blog_category', 'blog_likes')->where('id', $blog->id)->first();
            $data = $blog;
            $data->views += 1;

            $data->save();
            $data->refresh();

            $data['total_likes'] = $blog->blog_likes->count();

            return $this->create_response('single blog', $data, 200);
        } catch (\Exception $e) {
            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function destroy(Blog $blog)
    {
        // $this->checkRole(['admin']);
        try {
            $data = $blog;
            $blog->delete();
            return $this->create_response('Deleted blog', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function store(StoreBlogRequest $request)
    {
        // $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            if ($request->hasFile('photo')) {

                $fileName = uniqid() . '.' . $request->file('photo')->extension();
                $photoPath = $request->file('photo')->storeAs('userphotos', $fileName);
            }
            $data = Blog::create([
                "photo" => $fileName,
                'title' => $valid['title'],
                'description' => $valid['description'],
                'blog_category' => $valid['blog_category']
            ]);
            return $this->create_response('Added blog', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        // $this->checkRole(['admin']);
        try {
            $valid = $request->validated();
            if ($request->hasFile('photo')) {
                $blog->photo ? Storage::disk('userphotos')->delete($blog->photo) : '';
                $fileName = uniqid() . '.' . $request->file('photo')->extension();
                $photoPath = $request->file('photo')->storeAs('userphotos', $fileName);
                $valid['photo']= $fileName;
            }
            // else{
                  $blog->update($valid);
                  $data=$blog;
                return $this->create_response('Updated blog', $data, 202);
            // }
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
