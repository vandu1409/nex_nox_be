<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BusinessProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::first();
        $city    = City::first();
        $district = District::first();
        $ward    = Ward::first();

        $urls = [
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/672/9fd/f09/6729fdf099716452975699.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/66f/63a/455/66f63a4558442866780255.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/11b/ddb/67e11bddb5bda210437699.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/3de/ed0/67e3deed0cc16364023221.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/677/3a0/ceb/6773a0ceb2f4d985284455.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/680/62f/e7d/68062fe7d9612037579127.jpg",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/3db/673/67e3db673ba8b462231233.png",
            "https://res.cloudinary.com/nifehub-production/image/upload/w_800/public/67e/3dd/2c0/67e3dd2c0ce06265443157.png"
        ];

        for ($i = 1; $i <= 10; $i++) {
            $business = Business::create([
                'name' => 'Khách sạn ABC ' . $i,
                'lat' => 10.762622 + ($i * 0.001),
                'long' => 106.660172 + ($i * 0.001),
                'is_published' => true,
                'opening_time_from' => '08:00',
                'opening_time_to' => '22:00',
                'price_from' => 400000,
                'price_to' => 2500000,
                'dashboard_type' => 'stay',
                'description' => 'Khách sạn cao cấp số ' . $i,
                'country_id' => $country->id,
                'city_id' => $city->id,
                'district_id' => $district->id,
                'ward_id' => $ward->id,
            ]);

            $product = Product::create([
                'name' => 'Phòng Deluxe ' . $i,
                'acreage' => 30 + $i,
                'child_out_of_quantity_fee' => 80000,
                'child_quantity' => 2,
                'product_type' => 'room',
                'last_check_out_fee' => 150000,
                'business_id' => $business->id,
            ]);

            ProductPrice::create([
                'price' => 750000,
                'price_holiday' => 950000,
                'price_in_hour' => 180000,
                'price_capital' => 700000,
                'price_overnight' => 850000,
                'price_save' => 650000,
                'price_weekend' => 800000,
                'price_with_card' => 700000,
                'product_id' => $product->id,
            ]);

            // 🔽 Gán ảnh cho mỗi business
            $randomUrls = collect($urls)->shuffle()->take(3);
            foreach ($randomUrls as $index => $url) {
                Image::create([
                    'file_name' => basename($url),
                    'disk_name' => Str::random(40) . '.' . pathinfo($url, PATHINFO_EXTENSION),
                    'file_path' => $url,
                    'imageable_id' => $business->id,
                    'imageable_type' => Business::class,
                    'sort_order' => $index + 1,
                    'is_featured' => $index === 0, // ảnh đầu tiên làm đại diện
                ]);
            }
        }
    }
}
