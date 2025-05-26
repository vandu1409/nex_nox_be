<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    use ApiResponse;
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request);

        if ($result['success']) {
            return $this->success($result);
        }

        return response()->json(['error' => $result['message']], 500);
    }
    public function login(LoginRequest $request){
        $result = $this->authService->login($request);

        if ($result['success']) {
            return $this->success($result['token'], 'Đăng nhập thành công');

        }

        return $this->error( [],$result['message'], 400);
    }

    public function logout(Request $request){
        return $this->authService->logout($request);
    }

    public function getUser()
    {
        return $this->authService->getUser();
    }

    public function updateUser(Request $request)
    {
        return $this->authService->updateUser($request);
    }

    public function refreshToken(Request $request)
    {
        $result =  $this->authService->refreshToken($request);
        return $this->success($result);
    }
}
