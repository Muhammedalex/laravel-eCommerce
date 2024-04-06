<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = [
        'title'
    ];
    public function product_sizes()
    {
        return $this->hasMany(ProductSize::class, 'size');
    }
}
