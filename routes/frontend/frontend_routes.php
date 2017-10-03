<?php
/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/

Route::get('/', 'FrontendController@index')->name('index');
Route::get('/home', 'FrontendController@index')->name('home');
