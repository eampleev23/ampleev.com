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

use App\Mail\TestAmazonSes;
use Illuminate\Support\Facades\Mail;

Auth::routes();

Route::group([
    'middleware' => 'auth',
], function () {

});

Route::group([
    'as' => 'blog.'
],
    function () {
        Route::get('/article_layout', 'BlogController@show_article_layout')->name('show_article_layout');
//        Route::get('/', 'BlogController@show')->name('home');
        Route::get('/', 'StaticController@about_me')->name('home');
        Route::get('/sitemap.xml', 'BlogController@sitemap')->name('sitemap');
        Route::get('/article_{article_text_url}', 'BlogController@show_article')->name('show_article');
        Route::get('/blog_section_{blog_section_name}', 'BlogController@show_blog_section')->name('show_blog_section');
        Route::post('/add-comment', 'BlogController@add_comment')->name('add_comment_post');
        Route::post('/add-subscriber', 'BlogController@add_subscriber')->name('add_subscriber');
        Route::get('/confirm-subscriber-{hash}', 'BlogController@confirmed_subscriber')->name('confirmed_subscriber');
    }
);

Route::group([
    'as' => 'static_pages.'
],
    function () {
        Route::get('/about_me', 'StaticController@about_me')->name('about_me');
    }
);

Route::group([
    'as' => 'utility.'
],
    function () {
        Route::get('/confirm_subscriber_{email}', 'BlogController@confirm_subscriber')->name('confirm_subscriber');
    }
);

Route::group([
    'as' => 'test.'
],
    function () {
        Route::get('/test_nav', 'TestController@show_nav')->name('nav');
        Route::get('/test_modals', 'TestController@show_modals')->name('modals');
        Route::get('/test_article', 'TestController@show_article_test')->name('article_test');
        Route::get('/test_aws', 'TestController@test_aws')->name('aws_test');
        Route::get('/test_mailing_lists_confirmation',
            'TestController@test_view_mailing_lists_confirmation')->name('mailing_lists_confirmation_test');

    }
);

Route::group([
    'as' => 'docs.'
],
    function () {
        Route::get('/terms-of-use', 'DocsController@show_terms_of_use')->name('terms_of_use');
    }
);


//Route::get('/', 'IndexController@show')->name('main');
//Route::get('/blog', 'BlogController@show')->name('test');


//facebook auth hyytdfndkjnfgdfjkgndfkjgndkjfgndkjfgn
Route::get('/redirect-{whereback}', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');


//Route::get('/home', 'HomeController@index')->name('home');
