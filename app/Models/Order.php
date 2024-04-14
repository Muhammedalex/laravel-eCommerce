<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'address_id',
        'coupon_id',
        'phone_id',
        'payment',
        'status',
        'total_price'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {

        return $this->belongsTo(Address::class);
    }
    public function coupon()
    {

        return $this->belongsTo(Coupon::class);
    }
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
