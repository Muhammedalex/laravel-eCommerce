<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class ColorController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()
    {
        $this->checkRole(['admin']);
        try {

            $data = Color::all();

            return $this->create_response('All colors', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function store(ColorRequest $request)
    {
        try {
            $valid = $request->validated();

            $data = Color::create($valid);

            return $this->create_response('Added color', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(ColorRequest $request, Color $color)
    {

        try {
            $valid = $request->validated();

            $color->update($valid);
            $data = $color;
            return $this->create_response('Updated color', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Color $color)
    {
        try {
            $data = $color;
            $color->delete();

            return $this->create_response('deleted color', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
