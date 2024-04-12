<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogLike;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class BlogLikeController extends Controller
{
    use CustomResponse, CheckRole;

    // public function like(Request $request, Blog $blog)
    // {
    //     $user_id = auth()->id();


    //     $existing_like = BlogLike::where('user_id', $user_id)
    //     ->where('blog_id', $blog->id)->first();

    //     if ($existing_like) {
    //         $existing_like->delete();
    //     } else {
    //         BlogLike::create([
    //             'user_id' => $user_id,
    //             'blog_id' => $blog->id
    //         ]);
    //     }


    public function like(Request $request, Blog $blog)
    {
        $user_id = $request->user_id;

        $blog_id = $request->blog_id;
        // $user_id = auth()->id();

        // Check for existing like and toggle it
        $existing_like = BlogLike::where('user_id', $user_id)
            ->where('blog_id', $blog_id)
            ->first();

        if ($existing_like) {
            $existing_like->delete();
        } else {
            BlogLike::create([
                'user_id' => $user_id,
                'blog_id' => $blog_id
            ]);
        }
    }
}
