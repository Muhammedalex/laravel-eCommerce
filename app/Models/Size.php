<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'size'
    ];
    public function product_sizes()
    {
        return $this->hasMany(ProductSize::class, 'size', 'size');
    }
}
