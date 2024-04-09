<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class SizeController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()

    {
        $this->checkRole(['admin']);
        try {
            $data =  Size::all();


            return $this->create_response('All sizes', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function store(SizeRequest $request)

    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            $data = Size::create($valid);
            return $this->create_response('Added size', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(SizeRequest $request, Size $size)

    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();
            $data = $size->update($valid);
            return $this->create_response('Updated size', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function destroy(Size $size)


    {
        $this->checkRole(['admin']);
        try {
            $data = $size->delete();
            return $this->create_response('Deleted size', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
