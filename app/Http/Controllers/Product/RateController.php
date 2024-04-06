<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRateRequest;
use App\Http\Requests\Product\UpdateRateRequest;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{

    public function index()
    {
        $rates = Rate::with('product')->get();
        return  $rates;
    }


    public function store(StoreRateRequest $request)
    {
        $data = $request->validated();

        return Rate::create($data);
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
