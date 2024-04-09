<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRateRequest;
use App\Http\Requests\Product\UpdateRateRequest;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{

    public function index()
    {
        $rates = Rate::with('product')->get();
        return $rates;
    }


    public function store(StoreRateRequest $request)
    {
        $valid = $request->validated();
        Rate::create($valid);
        $products = Product::with('rates')->get();
        // return $products;

        foreach ($products as $product) {
            $rateCount = $product->rates->count();
            // return $rateCount;
            $averageRate = $rateCount > 0 ? $product->rates->avg('rate') : 0;


            $product->update(['total_rating' => $averageRate]);
        }
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

    public function rate()
    {
        $products = Product::with('rates')->get();
        // return $products;

        foreach ($products as $product) {
            $rateCount = $product->rates->count();
            // return $rateCount;
            $averageRate = $rateCount > 0 ? $product->rates->avg('rate') : 0;


            $product->update(['total_rating' => $averageRate]);
        }
    }
}
