<?php

namespace App\Services;

use App\Repositories\CityRepository;

class CityService
{
    protected $cityRepo;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepo = $cityRepo;
    }

    public function getAll(){
        return $this->cityRepo->getAll();
    }

}
