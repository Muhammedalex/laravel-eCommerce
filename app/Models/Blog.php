<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'views', 'photo', 'blog_category'
    ];

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category', 'blog_category');
    }
    public function blog_likes()
    {
        return $this->hasMany(BlogLike::class);
    }
}
