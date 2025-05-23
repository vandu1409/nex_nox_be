<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProfile::insert([
            [
                'user_id' => 1,
                'full_name' => 'Nguyễn Văn A',
                'phone' => '0912345678',
                'email' => 'nguyenvana@example.com',
                'id_card_number' => '123456789',
                'address' => '123 Lê Lợi, Q.1, TP.HCM',
            ],
            [
                'user_id' => 2,
                'full_name' => 'Trần Thị B',
                'phone' => '0987654321',
                'email' => 'tranthib@example.com',
                'id_card_number' => '987654321',
                'address' => '456 Trần Hưng Đạo, Q.5, TP.HCM',
            ],
            [
                'user_id' => 3,
                'full_name' => 'Lê Văn C',
                'phone' => '0909090909',
                'email' => 'levanc@example.com',
                'id_card_number' => '456789123',
                'address' => '789 Nguyễn Trãi, Q.10, TP.HCM',
            ],
        ]);

    }
}
