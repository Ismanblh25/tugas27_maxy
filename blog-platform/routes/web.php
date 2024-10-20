<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;  
use App\Http\Controllers\UserController;  
use App\Http\Controllers\PostController;

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

Route::get('/auth/callback/{provider}', function ($provider) {
    $user = Socialite::driver($provider)->stateless()->user();
    
    $user = \App\Models\User::firstOrCreate([
        'email' => $user->getEmail(),
    ], [
        'name' => $user->getName(),
        'provider_id' => $user->getId(),
        'provider_name' => $provider,
    ]);

    Auth::login($user);
    return redirect('/home');
});

Route::get('/2fa/enable', [UserController::class, 'enableTwoFactorAuth'])->middleware('auth')->name('2fa.enable');
Route::post('/2fa/verify', [UserController::class, 'verifyTwoFactorAuth'])->middleware('auth')->name('2fa.verify');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
