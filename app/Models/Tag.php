<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'title'
    ];
    public function product_tags()
    {
        return  $this->hasMany(ProductTag::class, 'tag');
    }
}
