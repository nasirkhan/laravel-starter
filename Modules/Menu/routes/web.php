<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// /*
// *
// * Frontend Routes
// *
// * --------------------------------------------------------------------
// */
// Route::group(['namespace' => '\Modules\Menu\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {

//     /*
//      *
//      *  Frontend Menus Routes
//      *
//      * ---------------------------------------------------------------------
//      */
//     $module_name = 'menus';
//     $controller_name = 'MenusController';
//     Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
//     Route::get("$module_name/{id}/{slug?}", ['as' => "$module_name.show", 'uses' => "$controller_name@show"]);
// });

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Menu\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Menus Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'menus';
    $controller_name = 'MenusController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");

    /*
     *
     *  Backend Menu Items Routes
     *  Note: Menu items are managed through the menus show page, not as standalone resources
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'menuitems';
    $controller_name = 'MenuItemsController';

    // Redirect old menu items index to menus index for backward compatibility
    Route::get("$module_name", function () {
        flash('Menu items are listed within their parent menus.')->info();

        return redirect()->route('backend.menus.index');
    })->name("$module_name.index");

    // Other menu item routes
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);

    // Resource routes excluding index (handled above with redirect)
    Route::resource("$module_name", "$controller_name")->except(['index']);
});
