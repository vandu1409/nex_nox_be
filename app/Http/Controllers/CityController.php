<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityService;
    use ApiResponse;

    public function __construct(CityService $cityService){
        $this->cityService = $cityService;
    }

    public function getAll()
    {
       return $this->success($this->cityService->getAll());
    }
}
