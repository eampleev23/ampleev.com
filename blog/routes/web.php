<?php

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

// Пример роута без авторизации
//Route::get('sbytnr0fwr1tdvvnh0kr5ln1', 'PlaceController@test')->name('test');

Auth::routes();

Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/', 'IndexController@show')->name('main');
    Route::get('/home', 'HomeController@index')->name('home');

});


Route::get('/blog', 'BlogController@show')->name('test');


//facebook auth
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');


//Route::get('/home', 'HomeController@index')->name('home');
