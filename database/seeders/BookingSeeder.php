<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\BookingType;
use App\Models\Booking;
use App\Models\Product;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $userProfiles = UserProfile::all();
        $products = Product::all();

        if ($userProfiles->isEmpty() || $products->isEmpty()) {
            $this->command->info('⚠️ Cần có dữ liệu UserProfile và Product trước khi seed Booking.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            $user = $userProfiles->random();
            $product = $products->random();

            $start = Carbon::now()->addDays(rand(1, 10))->setTime(rand(8, 20), 0);
            $end = (clone $start)->addHours(rand(1, 4));

            Booking::create([
                'booking_type' => rand(0, 1) ? BookingType::Hourly : BookingType::Daily,
                'start_time' => $start,
                'end_time' => $end,
                'guest_adults' => rand(1, 4),
                'guest_children' => rand(0, 2),
                'status' => collect([BookingStatus::Confirmed,BookingStatus::CheckedIn,BookingStatus::CheckedOut,BookingStatus::Cancelled,BookingStatus::Pending])->random(),
                'total_price' => rand(500000, 1500000),
                'deposit' => rand(100000, 500000),
                'special_requests' => collect([
                    'Không hút thuốc',
                    'Có nôi cho trẻ em',
                    'Phòng gần thang máy',
                    'Càng yên tĩnh càng tốt',
                    'Có view đẹp'
                ])->random(),
                'user_profile_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        $this->command->info('✅ Đã tạo 10 booking mẫu!');
    }

}
