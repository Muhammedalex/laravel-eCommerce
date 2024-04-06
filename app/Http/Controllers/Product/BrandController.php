<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreBrandRequest;
use App\Http\Requests\Product\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{


    public function index()
    {
        $brands = Brand::all();
        return $brands;
    }


    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();

        return Brand::create($data);
    }


    public function update(UpdateBrandRequest $request, Brand $brand)
    {

        $data = $request->validated();
        return $brand->update($data);
    }

    public function destroy(Brand  $brand)
    {
        return $brand->delete();
    }
}
