<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return $colors;
    }


    public function store(ColorRequest $request)
    {
        $data = $request->validated();

        return Color::create($data);
    }


    public function update(ColorRequest $request, Color $color)
    {

        $data = $request->validated();
        return $color->update($data);
    }

    public function destroy(Color $color)
    {
        return $color->delete();
    }
}
