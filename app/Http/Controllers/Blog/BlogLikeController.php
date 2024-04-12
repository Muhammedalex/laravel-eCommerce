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



    public function like()
    {
    }
}
