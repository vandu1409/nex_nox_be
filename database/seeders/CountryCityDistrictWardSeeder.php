<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryCityDistrictWardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Country
        $vn = Country::create(['name' => 'Việt Nam']);

        // Tạo City
        $hcm = City::create(['name' => 'TP. Hồ Chí Minh', 'country_id' => $vn->id]);
        $hn  = City::create(['name' => 'Hà Nội', 'country_id' => $vn->id]);

        // Tạo District cho TP.HCM
        $q1 = District::create(['name' => 'Quận 1', 'city_id' => $hcm->id]);
        $q3 = District::create(['name' => 'Quận 3', 'city_id' => $hcm->id]);

        // Tạo District cho Hà Nội
        $qba = District::create(['name' => 'Quận Ba Đình', 'city_id' => $hn->id]);

        // Tạo Ward cho Quận 1
        Ward::create(['name' => 'Phường Bến Nghé', 'district_id' => $q1->id]);
        Ward::create(['name' => 'Phường Bến Thành', 'district_id' => $q1->id]);

        // Tạo Ward cho Quận 3
        Ward::create(['name' => 'Phường Võ Thị Sáu', 'district_id' => $q3->id]);

        // Tạo Ward cho Quận Ba Đình
        Ward::create(['name' => 'Phường Điện Biên', 'district_id' => $qba->id]);

    }
}
