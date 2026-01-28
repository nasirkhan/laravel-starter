<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::livewire('login', Login::class)->name('login');
    if (user_registration()) {
        Route::livewire('register', Register::class)->name('register');
    }
    Route::livewire('forgot-password', ForgotPassword::class)->name('password.request');
    Route::livewire('reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::livewire('verify-email', VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::livewire('confirm-password', ConfirmPassword::class)
        ->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

// Social Login Routes
Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
    Route::get('login/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('social.login');
    Route::get('login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('social.login.callback');
});
