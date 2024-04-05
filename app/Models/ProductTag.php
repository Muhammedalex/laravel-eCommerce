<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag_id',
        'product_id'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}