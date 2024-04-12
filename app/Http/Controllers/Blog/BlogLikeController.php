<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogLike;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\Auth;

class BlogLikeController extends Controller
{
    use CustomResponse, CheckRole;

    public function like(Blog $blog)
    {
        $this->checkRole(['user']);
        $user = Auth::user();
        // dd();
        $userExsisting = $blog->blog_likes->where('user_id',$user->id)->first();
        if($userExsisting){
            $userExsisting->delete();
            return $this->create_response('user dislike', $userExsisting, 203);

        } elseif(!$userExsisting){
            BlogLike::create([
                'user_id'=>$user->id,
                'blog_id'=>$blog->id
            ]);
            $data = $blog;
            return $this->create_response('Added like', $data, 201);

        }
    }
}
