<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'quantity',
        'slug',
        'price',
        'description',

        'category_id',
        'brand_id',


    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function product_colors()
    {
        return $this->hasMany(ProductColor::class);
    }
    public function product_sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
    public function product_tags()
    {
        return $this->hasMany(ProductTag::class);
    }
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}
