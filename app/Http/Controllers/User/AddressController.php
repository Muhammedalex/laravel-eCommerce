<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAddressRequest;
use App\Http\Requests\User\UpdateAddressRequest;
use App\Models\Address;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()
    {
        $this->checkRole(['admin']);
        try {

            $data = Address::all();

            return $this->create_response('All addresss', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function store(StoreAddressRequest $request)
    {
        try {
            $valid = $request->validated();

            $data = address::create($valid);

            return $this->create_response('Added address', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function show(Address $address){
        try {
            
            $data=$address;

            return $this->create_response('Added address', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {

        try {
            $valid = $request->validated();

            $address->update($valid);
            $data = $address;
            return $this->create_response('Updated address', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Address $address)
    {
        try {
            $data = $address;
            $address->delete();

            return $this->create_response('deleted address', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
