<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->stateless()->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback() {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),

        ], [
            'password' => bcrypt(Str::random(16)),
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->view('google-login-success', ['token' => $token]);
    }

}
