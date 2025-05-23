<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{

    public function getAll()
    {
        return City::all();
    }

}
