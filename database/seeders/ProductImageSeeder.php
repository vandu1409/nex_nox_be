<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $urls = [
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/668/e6c/bb9/668e6cbb90b94334213109.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/668/e6c/027/668e6c027d775855993112.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/668/e6b/2f9/668e6b2f9f077225321233.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/668/e6a/5bd/668e6a5bd98e3864095814.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/669/1f7/560/6691f75608803337712541.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/669/1f5/4f0/6691f54f08632785601287.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/669/1f4/393/6691f43938912804364428.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_200/public/669/1f3/8c3/6691f38c39ee1081806050.jpg",
        ];

        $products = Product::all();

        foreach ($products as $product) {
            $selected = collect($urls)->shuffle()->take(3); // Lấy 3 ảnh ngẫu nhiên
            foreach ($selected as $index => $url) {
                Image::create([
                    'file_name' => basename($url),
                    'disk_name' => Str::random(40) . '.' . pathinfo($url, PATHINFO_EXTENSION),
                    'file_path' => $url,
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                    'sort_order' => $index + 1,
                    'is_featured' => $index === 0,
                ]);
            }
        }
    }

}
