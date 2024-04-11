<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogLike;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductPhoto;
use App\Models\ProductSize;
use App\Models\ProductTag;
use App\Models\Rate;
use App\Models\Size;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();

        //  User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Category::factory(4)->create();
        Brand::factory(10)->create();
        Product::factory(20)->create();
        Color::factory(5)->create();
        ProductColor::factory(50)->create();
        Size::factory(4)->create();
        ProductSize::factory(50)->create();
        Tag::factory(3)->create();
        ProductTag::factory(10)->create();
        ProductPhoto::factory(80)->create();
        Rate::factory(50)->create();
        BlogCategory::factory(5)->create();
        Blog::factory(20)->create();
        BlogLike::factory(50)->create();
    }
}
