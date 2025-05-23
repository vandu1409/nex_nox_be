<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\MailService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): array
    {
        try {

            $user = $this->userRepository->createToUser([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);


            $token = JWTAuth::fromUser($user);
            $verifyUrl = '/verify-email?token=' . $token;

//            Mail::to($user->email)->send(new MailService($verifyUrl));

            return [
                'success' => true,
                'token' => $token,
            ];
        } catch (\Exception $e) {
            Log::error('[Register Error]: ' . $e->getMessage());
        }
        return [];
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $user = User::where('email', $credentials['email'])->first();

            if (!empty($user->google_id)) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản này đăng nhập bằng Google, vui lòng đăng nhập bằng Google'
                ];
            }

            if (!$token = JWTAuth::attempt($credentials)) {
                return [
                    'success' => false,
                    'message' => 'Đăng nhập thất bại vui lòng thử lại!'
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Đăng nhập thất bại vui lòng thử lại!'
            ];
        }

        return [
            'success' => true,
            'token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ]
        ];
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser()
    {
        try {
            $user = Auth::user();
            if (!$user) return response()->json(['error' => 'User not found'], 404);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user profile'], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userRepository->updateToUser($user->id, $request->only(['name', 'email', 'phone']));

            return response()->json(User::find($user->id));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user'], 500);
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return ['token' => $newToken, 'message' => 'Token refreshed', 'code' => 200];
        } catch (JWTException $e) {
            return ['message' => 'Token refresh failed', 'code' => 500];
        }
    }
}
