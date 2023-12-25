<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('openid-connect')->name('openid_connect.')->group(function () {
    Route::name('redirect')->get('/redirect', function () {
        return Socialite::driver('keycloak')->redirect();
    });

    Route::name('callback')->get('/callback', function () {
        $user = Socialite::driver('keycloak')->user();

        dd($user);
    });
});
