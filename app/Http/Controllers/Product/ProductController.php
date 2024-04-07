<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->with('brand')
            ->with('product_colors.color')
            ->with('product_sizes.size')
            ->with('product_tags.tag')
            ->with('photos')
            ->paginate(10);
        return $products;
    }



    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);
        return $product;
    }


    public function show(Product $product)
    {
        $product = Product::with('category')->with('brand')
            ->with('product_colors.color')
            ->with('product_sizes.size')
            ->with('product_tags.tag')
            ->with('photos')
            ->first();
        return $product;
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);
        return $product;
    }


    public function destroy(Product $product)
    {

        return  $product->delete();
    }
}
