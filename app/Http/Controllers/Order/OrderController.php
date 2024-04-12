<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        // dd($user->carts);
        try {
            $total = 0;
            $valid = $request->validated();
            $valid['user_id'] = $user->id;
            $data = Order::create($valid);
            // dd($user->is('carts'));
            if ($user->carts && count($user->carts) > 0) {
                foreach ($user->carts as $cart) {
                    $order_detail = OrderDetail::create([
                        'order_id'   => $data->id,
                        'product_id' => $cart->product_id,
                        'quantity'   => $cart->quantity,
                        'price'      => $cart->total_price,
                        'color'      => $cart->color,
                        'size'       => $cart->size
                    ]);
                    $cart->delete();

                    $total += $order_detail->price;
                }
                $data->total_price = $total;
                $data->save();
                return $data;
            }
            return 'no cart';
            // dd($data);
        } catch (\Exception $e) {
            return 'error';
        }
    }
}
