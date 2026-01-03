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
use App\Http\Controllers\StaticController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Mail;

Auth::routes();

// Роут для поддомена pointscounter.ampleev.com
// Должен быть ПЕРВЫМ, чтобы иметь приоритет над общими роутами
Route::domain('pointscounter.ampleev.com')->group(function () {
    Route::get('/', [StaticController::class, 'pointscounter'])->name('pointscounter');
});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
});

Route::group([
    'as' => 'blog.'
],
    function () {
        Route::get('/article_layout', [BlogController::class, 'show_article_layout'])->name('show_article_layout');
        // Главная страница сайта открывает страницу "Обо мне"
        Route::get('/blog', [BlogController::class, 'show'])->name('blog');
        Route::get('/sitemap.xml', [BlogController::class, 'sitemap'])->name('sitemap');
        Route::get('/article_{article_text_url}', [BlogController::class, 'show_article'])->name('show_article');
        Route::get('/blog_section_{blog_section_name}', [BlogController::class, 'show_blog_section'])
            ->where('blog_section_name', '.*')
            ->name('show_blog_section');
        Route::post('/add-comment', [BlogController::class, 'add_comment'])
            ->middleware('throttle:comments')
            ->name('add_comment_post');
        Route::post('/add-subscriber', [BlogController::class, 'add_subscriber'])->name('add_subscriber');
        Route::get('/confirm-subscriber-{hash}', [BlogController::class, 'confirmed_subscriber'])->name('confirmed_subscriber');
        Route::get('/unsubscribe-comment-notifications', [BlogController::class, 'unsubscribe_comment_notifications'])->name('unsubscribe_comment_notifications');
        Route::get('/unsubscribe-mailing-{hash}', [BlogController::class, 'unsubscribe_mailing'])->name('unsubscribe_mailing');
    }
);

Route::group([
    'as' => 'static_pages.'
],
    function () {
        // Главная страница сайта открывает страницу "Обо мне"
        Route::get('/', [StaticController::class, 'about_me'])->name('home');
        Route::get('/about_me', [StaticController::class, 'about_me'])->name('about_me');
        Route::get('/about_company', [StaticController::class, 'about_company'])->name('about_company');
        Route::get('/contact', [StaticController::class, 'contact'])->name('contact');
        Route::post('/contact', [StaticController::class, 'contact_submit'])->name('contact_submit');
    }
);

Route::group([
    'as' => 'products.'
],
    function () {
        Route::get('/products', [ProductsController::class, 'index'])->name('index');
    }
);

Route::group([
    'as' => 'utility.'
],
    function () {
        Route::get('/confirm_subscriber_{email}', [BlogController::class, 'confirm_subscriber'])->name('confirm_subscriber');
    }
);

Route::group([
    'as' => 'test.'
],
    function () {
        Route::get('/test_nav', [TestController::class, 'show_nav'])->name('nav');
        Route::get('/test_modals', [TestController::class, 'show_modals'])->name('modals');
        Route::get('/test_article', [TestController::class, 'show_article_test'])->name('article_test');
        Route::get('/test_aws', [TestController::class, 'test_aws'])->name('aws_test');
        Route::get('/test_mailing_lists_confirmation',
            [TestController::class, 'test_view_mailing_lists_confirmation'])->name('mailing_lists_confirmation_test');

    }
);

Route::group([
    'as' => 'docs.'
],
    function () {
        Route::get('/terms-of-use', [DocsController::class, 'show_terms_of_use'])->name('terms_of_use');
    }
);

// Preview черновиков статей
Route::get('/drafts/{text_url}', [DraftController::class, 'preview'])->name('draft.preview');


//Route::get('/', 'IndexController@show')->name('main');
//Route::get('/blog', 'BlogController@show')->name('test');


//facebook auth hyytdfndkjnfgdfjkgndfkjgndkjfgndkjfgn
//Route::get('/redirect-{whereback}', 'SocialAuthFacebookController@redirect');
//Route::get('/callback', 'SocialAuthFacebookController@callback');

//vk auth
//Route::get('/redirect-vk', 'SocialAuthVkController@redirect');
//Route::get('/redirect-vk', 'SocialAuthVkController@callback');
//Route::get('/redirect-yandex', 'SocialAuthVkController@callback');
Route::get('login/yandex', [AuthenticatedSessionController::class, 'yandex'])->name('yandex');
Route::get('login/yandex/redirect', [AuthenticatedSessionController::class, 'yandexRedirect'])->name('yandexRedirect');
//Route::get('/redirect-vk', 'SocialAuthVkController@callback');



//Route::get('/home', 'HomeController@index')->name('home');
