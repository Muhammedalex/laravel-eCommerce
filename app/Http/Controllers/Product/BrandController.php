<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreBrandRequest;
use App\Http\Requests\Product\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Requestuse;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class BrandController extends Controller
{
    use CustomResponse, CheckRole;


    public function index()
    {
        $this->checkRole(['admin']);
        try {
            $data = Brand::all();


            return $this->create_response('All brands', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function store(StoreBrandRequest $request)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            $data = Brand::create($valid);
            return $this->create_response('Added brand', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();
            $data = $brand->update($valid);
            return $this->create_response('Updated brand', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Brand  $brand)
    {
        $this->checkRole(['admin']);
        try {
            $data = $brand->delete();
            return $this->create_response('Deleted brand', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
