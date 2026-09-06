<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
*
* Auth Routes
*
* --------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/

// home route
Route::livewire('home', 'pages::frontend.home')->name('home');

// Language Switch
Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

Route::livewire('dashboard', 'pages::frontend.home')->name('dashboard');

// pages
Route::livewire('terms', 'pages::frontend.terms')->name('terms');
Route::livewire('privacy', 'pages::frontend.privacy')->name('privacy');

Route::group(['as' => 'frontend.'], function () {
    Route::livewire('/', 'pages::frontend.home')->name('index');

    Route::group(['middleware' => ['auth']], function () {
        /*
        *
        *  Users Routes
        *
        * ---------------------------------------------------------------------
        */
        $module_name = 'users';
        Route::livewire('profile/edit', 'pages::frontend.users.profile-edit')->name("{$module_name}.profileEdit");
        Route::livewire('profile/changePassword', 'pages::frontend.users.change-password')->name("{$module_name}.changePassword");
        Route::livewire('profile/{username?}', 'pages::frontend.users.profile')->name("{$module_name}.profile");
    });
});
