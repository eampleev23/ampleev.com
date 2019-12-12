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

    Route::group([
        'as' => 'blog.'
    ],
        function () {
            Route::get('/blog', 'BlogController@show_old')->name('home');
            Route::get('/blog-article', 'BlogController@show_article_test')->name('article_test');
            Route::get('/article-{article_id}', 'BlogController@show_article')->name('show_article');
        }
    );

});


Route::get('/', 'IndexController@show')->name('main');
//Route::get('/blog', 'BlogController@show')->name('test');


//facebook auth
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');


//Route::get('/home', 'HomeController@index')->name('home');
