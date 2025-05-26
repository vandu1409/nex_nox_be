<?php

namespace App\Http\Controllers;

use App\Services\BusinessService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected $businessService;
    use ApiResponse;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }
    public function search(Request $request)
    {
        return $this->success($this->businessService->search($request));
    }
    public function searchByType(Request $request)
    {
        return $this->success($this->businessService->searchByType($request));
    }
    public function searchByName(Request $request)
    {
        return $this->success($this->businessService->searchByName($request));
    }

}
