<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return  $tags;
    }


    public function store(TagRequest $request)
    {
        $data = $request->validated();

        return Tag::create($data);
    }


    public function update(TagRequest $request, Tag $tag)
    {

        $data = $request->validated();
        return $tag->update($data);
    }

    public function destroy(Tag $tag)
    {
        return $tag->delete();
    }
}
