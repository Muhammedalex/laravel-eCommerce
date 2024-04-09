<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StorePhotoProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductPhoto;
use App\Models\ProductSize;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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



    public function store(StoreProductRequest $request, StorePhotoProductRequest $imgRequest)
    {
        try {
            $data = $request->validated();
            $imgRequest->validated();
            // dd($request);
            DB::beginTransaction();
            $product = Product::create($data);
            foreach ($imgRequest->color as $color) {
                ProductColor::create([
                    "color" => $color,
                    "product_id" => $product->id
                ]);
            }

            foreach ($imgRequest->size as $size) {
                ProductSize::create([
                    "size" =>  $size,
                    "product_id" => $product->id
                ]);
            }
            foreach ($imgRequest->tag as $tag) {
                ProductTag::create([
                    "tag" =>  $tag,
                    "product_id" => $product->id
                ]);
            }
            if ($request->hasFile('photo')) {
                foreach ($imgRequest->file('photo') as $img) {
                    if ($img->isValid()) {
                        $fileName = uniqid() . '.' . $img->extension();
                        $photoPath = $img->storeAs('userphotos', $fileName);
                        ProductPhoto::create([
                            "photo" => $fileName,
                            "product_id" => $product->id
                        ]);
                    }
                }
            }
            $newProduct = Product::with('photos','product_colors.color','product_sizes','product_tags')->find($product->id);
            DB::commit();
            return $newProduct;
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['success' => false], 401);
        }
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
