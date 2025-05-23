<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('reviews')->insert([
            [
                'business_id' => 1,
                'user_profile_id' => 10,
                'star' => 5,
                'comment' => 'Dịch vụ rất tốt!',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'business_id' => 1,
                'user_profile_id' => 11,
                'star' => 4,
                'comment' => 'Khá hài lòng.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'business_id' => 2,
                'user_profile_id' => 12,
                'star' => 3,
                'comment' => 'Phục vụ trung bình.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

}
