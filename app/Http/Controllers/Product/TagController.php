<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class TagController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()


    {
        $this->checkRole(['admin']);
        try {
            $data = Tag::all();


            return $this->create_response('All Tags', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function store(TagRequest $request)

    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            $data = Tag::create($valid);
            return $this->create_response('Added Tag', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function update(TagRequest $request, Tag $tag)

    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();
            $tag->update($valid);
            $data = $tag;
            return $this->create_response('Updated tag', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Tag $tag)

    {
        $this->checkRole(['admin']);
        try {
            $data = $tag;
            $tag->delete();
            return $this->create_response('Deleted tag', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
