<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

Route::get('/cache-test', function () {
    $key = 'business_search_test';
    $value = Cache::remember($key, 600, function () {
        return 'cached data';
    });
    return Cache::get($key);
});

Route::get('/show-cache', function() {
    $key = 'business-search_de91fc7b1537ae8eaf4b9e9a62e48c9d';
    $value = Cache::get($key);
    return response()->json($value);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/search',[BusinessController::class,'search']);
Route::get('/search-by-type',[BusinessController::class,'searchByType']);
Route::get('/search-by-name',[BusinessController::class,'searchByName']);
Route::get('/cities',[CityController::class,'getAll']);

Route::get('/auth/redirect/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/callback/google', [SocialAuthController::class, 'handleGoogleCallback']);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user', [AuthController::class, 'updateUser']);
    Route::post('/refresh',[AuthController::class, 'refreshToken']);
});
