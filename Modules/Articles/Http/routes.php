<?php

Route::group(['middleware' => 'web', 'prefix' => 'articles', 'namespace' => 'Modules\Articles\Http\Controllers'], function () {
    Route::get('/', 'ArticlesController@index');
});
