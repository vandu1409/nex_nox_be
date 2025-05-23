<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductWithImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageUrls = [
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/672/9fd/f09/6729fdf099716452975699.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/66f/63a/455/66f63a4558442866780255.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/11b/ddb/67e11bddb5bda210437699.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/3de/ed0/67e3deed0cc16364023221.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/677/3a0/ceb/6773a0ceb2f4d985284455.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/680/62f/e7d/68062fe7d9612037579127.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/3db/673/67e3db673ba8b462231233.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/3dd/2c0/67e3dd2c0ce06265443157.png"
        ];

        $businesses = Business::all();

        foreach ($businesses as $business) {
            for ($i = 1; $i <= 3; $i++) {
                $product = Product::create([
                    'name' => "Phòng Standard {$i} - {$business->id}",
                    'acreage' => rand(25, 40),
                    'child_out_of_quantity_fee' => 50000,
                    'child_quantity' => 2,
                    'usage_quantity' => 4,
                    'place_quantity' => 1,
                    'product_type' => 'room',
                    'last_check_out_fee' => 100000,
                    'business_id' => $business->id,
                ]);

                ProductPrice::create([
                    'price' => rand(500000, 800000),
                    'price_holiday' => rand(900000, 1200000),
                    'price_in_hour' => rand(100000, 200000),
                    'price_capital' => rand(400000, 600000),
                    'price_overnight' => rand(700000, 1000000),
                    'price_save' => rand(450000, 700000),
                    'price_weekend' => rand(800000, 1100000),
                    'price_with_card' => rand(600000, 900000),
                    'product_id' => $product->id,
                ]);

                $shuffled = collect($imageUrls)->shuffle()->take(rand(2, 3))->values();

                foreach ($shuffled as $index => $url) {
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

}
