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
use App\Traits\CheckRole;
use App\Traits\CustomResponse;

class ProductController extends Controller
{
    use CustomResponse, CheckRole;

    public function index()
    {

        try {

            $products = Product::with('category')->with('brand')
                ->with('product_colors.color')
                ->with('product_sizes.size')
                ->with('product_tags.tag')
                ->with('photos')
                ->paginate(10);
            $data = $products;
            return $this->create_response('all products', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }



    public function store(StoreProductRequest $request, StorePhotoProductRequest $imgRequest)
    {
        $this->checkRole(['admin']);
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
            $newProduct = Product::with('photos', 'product_colors.color', 'product_sizes', 'product_tags')->find($product->id);
            DB::commit();
            return $newProduct;
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['success' => false], 401);
        }
    }


    public function show(Product $product)
    {

        try {
            $data =
                $product = Product::with('category')->with('brand')
                ->with('product_colors.color')
                ->with('product_sizes.size')
                ->with('product_tags.tag')
                ->with('photos')
                ->first();
            $data = $product;
            return $this->create_response('single product', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();

            $data = $product->update($valid);

            return $this->create_response('Updated product', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }


    public function destroy(Product $product)
    {
        $this->checkRole(['admin']);
        try {
            $data = $product->delete();
            return $this->create_response('Deleted product', $data, 201);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
