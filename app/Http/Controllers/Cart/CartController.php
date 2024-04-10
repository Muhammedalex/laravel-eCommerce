<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartController extends Controller
{
    use CustomResponse, CheckRole;

    public function index(){
        $this->checkRole(['user']);
        try {
            $user = Auth::user();
           
            $data = Cart::with('product')->where('user_id',$user->id)->get();
    
            return $this->create_response('Get Shopping Cart Successfully', $data, 200);
        } catch (\Exception $e) {
            
            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        
        }
    }

    public function store(StoreCartRequest $request)
{
    $this->checkRole(['admin']);
    try {
        $user = Auth::user();
        $product = Product::find($request->product_id);
        
        $data = Cart::create([
            'quantity' => $request->quantity,
            'color' => $request->color,
            'size' => $request->size,
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'total_price'=>$request->quantity * $product->price
        ]);
        return $this->create_response('Added To Cart', $data, 201);
    } catch(NotFoundHttpException $e){
        return $this->error_response('Not Found', $e->getMessage(), 404);
    }
}

    public function update(UpdateCartRequest $request , Cart $shopping_cart)
    {
        $this->checkRoleAndUser(['admin'],$shopping_cart->user_id);
        try {
            $valid = $request->validated();
            if($request->quantity){
                $shopping_cart->update([
                    'quantity'=>$request->quantity,
                    'total_price'=>$request->quantity * $shopping_cart->product->price
                ]);
            } else {
                 $shopping_cart->update($valid);
            }

            $data= $shopping_cart;
    
            return $this->create_response('Updated Shopping Cart Successfully', $data, 202);
        } catch (\Exception $e) {
            
            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        
        }
    }

    public function destroy(Cart $shopping_cart)
    {
        $this->checkRoleAndUser(['admin'],$shopping_cart->user_id);
        try{
            $data= $shopping_cart;
            $shopping_cart->delete();
            return $this->create_response('Deleted Shopping Cart Successfully', $data, 203);
        } catch(\Exception $e){
            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
