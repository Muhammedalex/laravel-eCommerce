<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRateRequest;
use App\Http\Requests\Product\UpdateRateRequest;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class RateController extends Controller
{
    use CustomResponse, CheckRole;
    public function index()
    {
        $user = Auth::user();


        // $this->checkRole(['admin']);
        try {
            $data =  Rate::with('product')->where('user_id', $user->id)->get();


            return $this->create_response('All rates', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function store(StoreRateRequest $request)
    {
        $this->checkRole(['user']);
        try {
            $user = Auth::user();

            $valid = $request->validated();
            $data = Rate::create([
                'rate' => $request->rate,
                'comment' => $request->comment,
                'product_id' => $request->product_id,
                'user_id' => $user->id
            ]);
            if ($data) {
                $rates =  Rate::where('product_id', $request->product_id)->get();
                $averageRate = $rates->avg('rate');
                $product = Product::find($request->product_id);
                $product->total_rating = $averageRate;
                $product->save();
            }
            return response([$data, $product, $averageRate], 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function update(UpdateRateRequest $request, Rate $rate)

    {
        $this->checkRoleAndUser([''], $rate->user_id);

        try {
            $valid = $request->validated();
            $data = $rate->update($valid);
            return $this->create_response('Updated rate', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function destroy(Rate $rate)


    {
        $this->checkRoleAndUser(['admin'], $rate->user_id);

        try {
            $data =  $rate->delete();
            return $this->create_response('Deleted rate', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
