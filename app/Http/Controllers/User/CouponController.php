<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreCouponRequest;
use App\Http\Requests\User\UpdateCouponRequest;
use App\Models\Coupon;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;
use Carbon\Carbon;

class CouponController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()
    {
        // $this->checkRole(['admin']);
        try {

            $currentTime = Carbon::now();

            Coupon::where('expire', '<', $currentTime)
                ->update(['valid' => false]);
            $data = Coupon::where('valid', true)->get();


            return $this->create_response('All coupons', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function store(StoreCouponRequest $request)
    {
        try {
            $valid = $request->validated();

            $data = Coupon::create($valid);

            return $this->create_response('Added coupon', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function show(Coupon $coupon)
    {
        try {

            $data = $coupon;

            return $this->create_response('Added coupon', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {

        try {
            $valid = $request->validated();

            $coupon->update($valid);
            $data = $coupon;
            return $this->create_response('Updated coupon', $data, 202);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            $data = $coupon;
            $coupon->delete();

            return $this->create_response('deleted coupon', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
