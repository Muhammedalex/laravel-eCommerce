<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return  $sizes;
    }


    public function store(SizeRequest $request)
    {
        $data = $request->validated();

        return Size::create($data);
    }


    public function update(SizeRequest $request, Size $size)
    {

        $data = $request->validated();
        return $size->update($data);
    }

    public function destroy(Size $size)
    {
        return $size->delete();
    }
}
