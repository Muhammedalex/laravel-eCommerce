<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\CheckRole;

use function PHPUnit\Framework\isEmpty;
use App\Traits\CustomResponse;

class OrderController extends Controller
{
    use CustomResponse, CheckRole;


    public function index()
    {
        $this->checkRole(['admin']);
        try {
            $data = Order::with('order_details')->get();

            return $this->create_response('All orders', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    public function show(Order $order)
    {
        $this->checkRoleAndUser(['admin'], $order->user_id);
        try {
            $data = Order::with('order_details')->where('id', $order->id)->first();

            return $this->create_response('order', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }



    public function store(StoreOrderRequest $request)
    {
        try {
            $user = Auth::user();
            // dd($user->carts);
            // try {
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
                if ($data->coupon_id) {
                    $coupon = Coupon::where('id', $data->coupon_id)->first();
                    $expirationDate = Carbon::parse($coupon->expire);
                    if ($expirationDate->isFuture()) {
                        $data->total_price = $total - $coupon->discount;
                        $data->save();
                        return $this->create_response('added order with coupon', $data, 201);
                    }
                }
                $data->total_price = $total;
                $data->save();

                return $this->create_response('added order', $data, 201);
            }

            return $this->create_response('no cart', '', 404);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->checkRoleAndUser(['admin'], $order->user_id);
        try {
            $valid = $request->validated();
            $order->update($valid);
            $data = $order;
            return $this->create_response('Updated order', $data, 202);
        } catch (\Exception $e) {
            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function destroy(Order $order)
    {
        $this->checkRoleAndUser(['admin'], $order->user_id);
        try {
            $data = $order;

            $order->delete();
            return $this->create_response('Deleted order', $data, 203);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }

    public function archived()
    {
        $this->checkRole(['admin']);

        try {

            $data = Order::onlyTrashed()->get();

            return $this->create_response('deleted orders', $data, 200);
        } catch (\Exception $e) {

            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
}
