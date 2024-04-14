<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePhoneRequest;
use App\Http\Requests\User\UpdatePhoneRequest;
use App\Models\Phone;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;


class PhoneController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()
    {
        $this->checkRole(['admin']);
        try {

            $data = Phone::all();

            return $this->create_response('All Phones', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function store(StorePhoneRequest $request)
    {
        try {
            $valid = $request->validated();

            $data = Phone::create($valid);

            return $this->create_response('Added phone', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(UpdatePhoneRequest $request, Phone $phone)
    {

        try {
            $valid = $request->validated();

            $phone->update($valid);
            $data = $phone;
            return $this->create_response('Updated phone', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Phone $phone)
    {
        try {
            $data = $phone;
            $phone->delete();

            return $this->create_response('deleted phone', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
