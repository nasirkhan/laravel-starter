<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\LanguageController;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Privacy;
use App\Livewire\Frontend\Terms;
use App\Livewire\Frontend\Users\ChangePassword;
use App\Livewire\Frontend\Users\Profile;
use App\Livewire\Frontend\Users\ProfileEdit;
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
Route::livewire('home', Home::class)->name('home');

// Language Switch
Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

Route::livewire('dashboard', Home::class)->name('dashboard');

// pages
Route::livewire('terms', Terms::class)->name('terms');
Route::livewire('privacy', Privacy::class)->name('privacy');

Route::group(['as' => 'frontend.'], function () {
    Route::livewire('/', Home::class)->name('index');

    Route::group(['middleware' => ['auth']], function () {
        /*
        *
        *  Users Routes
        *
        * ---------------------------------------------------------------------
        */
        $module_name = 'users';
        Route::livewire('profile/edit', ProfileEdit::class)->name("{$module_name}.profileEdit");
        Route::livewire('profile/changePassword', ChangePassword::class)->name("{$module_name}.changePassword");
        Route::livewire('profile/{username?}', Profile::class)->name("{$module_name}.profile");
    });
});

/*
*
* Backend Routes
* These routes need view-backend permission
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', 'can:view_backend']], function () {
    /**
     * Backend Dashboard
     * Namespaces indicate folder structure.
     */
    Route::get('/', [BackendController::class, 'index'])->name('home');
    Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');

    /*
     *
     *  Notification Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'notifications';
    Route::get("{$module_name}", [NotificationsController::class, 'index'])->name("{$module_name}.index");
    Route::get("{$module_name}/markAllAsRead", [NotificationsController::class, 'markAllAsRead'])->name("{$module_name}.markAllAsRead");
    Route::delete("{$module_name}/deleteAll", [NotificationsController::class, 'deleteAll'])->name("{$module_name}.deleteAll");
    Route::get("{$module_name}/{id}", [NotificationsController::class, 'show'])->name("{$module_name}.show");

    /*
     *
     *  Roles Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'roles';
    Route::resource("{$module_name}", RolesController::class);

    /*
     *
     *  Users Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'users';
    Route::get("{$module_name}/{id}/resend-email-confirmation", [BackendUserController::class, 'emailConfirmationResend'])->name("{$module_name}.emailConfirmationResend");
    Route::delete("{$module_name}/user-provider-destroy", [BackendUserController::class, 'userProviderDestroy'])->name("{$module_name}.userProviderDestroy");
    Route::get("{$module_name}/{id}/change-password", [BackendUserController::class, 'changePassword'])->name("{$module_name}.changePassword");
    Route::patch("{$module_name}/{id}/change-password", [BackendUserController::class, 'changePasswordUpdate'])->name("{$module_name}.changePasswordUpdate");
    Route::get("{$module_name}/trashed", [BackendUserController::class, 'trashed'])->name("{$module_name}.trashed");
    Route::patch("{$module_name}/{id}/trashed", [BackendUserController::class, 'restore'])->name("{$module_name}.restore");
    Route::get("{$module_name}/index_data", [BackendUserController::class, 'index_data'])->name("{$module_name}.index_data");
    Route::get("{$module_name}/index_list", [BackendUserController::class, 'index_list'])->name("{$module_name}.index_list");
    Route::patch("{$module_name}/{id}/block", [BackendUserController::class, 'block'])->name("{$module_name}.block")->middleware('can:block_users');
    Route::patch("{$module_name}/{id}/unblock", [BackendUserController::class, 'unblock'])->name("{$module_name}.unblock")->middleware('can:block_users');
    Route::resource("{$module_name}", BackendUserController::class);
});
