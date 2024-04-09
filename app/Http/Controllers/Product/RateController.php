<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRateRequest;
use App\Http\Requests\Product\UpdateRateRequest;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{

    public function index()
    {
        $rates = Rate::with('product')->get();
        return $rates;
    }


    public function store(StoreRateRequest $request)
    {
        $user = Auth::user();
        // dd($user);//alex
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
    }

    public function update(UpdateRateRequest $request, Rate $rate)
    {
        $data = $request->validated();
        return $rate->update($data);
    }

    public function destroy(Rate $rate)
    {
        return $rate->delete();
    }
}
