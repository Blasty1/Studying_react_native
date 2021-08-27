<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [\App\Http\Controllers\Auth\LoginController::class,'login'] );
Route::post('register',[\App\Http\Controllers\Auth\RegisterController::class, 'register'] );

Route::get('google/redirect',[\App\Http\Controllers\SocialLogin::class, 'loginGoogle']);
Route::get('info_account/google',[\App\Http\Controllers\SocialLogin::class, 'linkGetInfoFromAccountGoogle']);
