<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tag'
    ];
    public function product_tags()
    {
        return  $this->hasMany(ProductTag::class, 'tag', 'tag');
    }
}
