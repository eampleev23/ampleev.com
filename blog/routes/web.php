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

use App\Article;
use App\Mail\TestAmazonSes;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminArticleFeedbackController;
use App\Http\Controllers\AdminMailingSubscriberController;
use App\Http\Controllers\ArticleFeedbackController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\EconomySimController;
use App\Support\SiteLocale;
use Illuminate\Support\Facades\Mail;

Auth::routes();

$randomHeroArticleRedirect = static function (string $locale) {
    $article = Article::with('translations')
        ->where('confirmed', 1)
        ->where('type_article', 'article')
        ->whereIn('article_layout', [Article::LAYOUT_IMAGE_HEADER, Article::LAYOUT_PARALLAX])
        ->where(function ($query) {
            $query->where(function ($imageQuery) {
                $imageQuery->whereNotNull('hero_image_path')
                    ->where('hero_image_path', '!=', '');
            })->orWhere(function ($imageQuery) {
                $imageQuery->whereNotNull('main_image_path')
                    ->where('main_image_path', '!=', '');
            });
        })
        ->inRandomOrder()
        ->first();

    if (!$article) {
        $fallbackUrl = $locale === SiteLocale::EN
            ? '/en/article_sprint_retrospective_and_ai_why_improvements_cannot_be_delegated_to_a_model'
            : '/article_sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli';

        return redirect($fallbackUrl);
    }

    return redirect()->route(
        SiteLocale::routeNameForLocale('blog.show_article', $locale),
        $article->getRouteTextUrl($locale)
    );
};

// Legacy redirect: EN Sprint Review article title changed ("is not a conversation" -> "does not replace the conversation").
Route::redirect(
    '/en/article_sprint_review_and_ai_why_a_demo_is_not_a_conversation_about_value',
    '/en/article_sprint_review_and_ai_why_a_demo_does_not_replace_the_conversation_about_value',
    301
);

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
        Route::get('/blog', [BlogController::class, 'show'])->defaults('site_locale', 'ru')->name('blog');
        Route::get('/sitemap.xml', [BlogController::class, 'sitemap'])->defaults('site_locale', 'ru')->name('sitemap');
        Route::get('/article_{article_text_url}', [BlogController::class, 'show_article'])->defaults('site_locale', 'ru')->name('show_article');
        Route::get('/daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom', [BlogController::class, 'show_article'])
            ->defaults('article_text_url', 'daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom')
            ->defaults('site_locale', 'ru')
            ->name('daily_scrum_ai_article');
        Route::get('/blog_section_{blog_section_name}', [BlogController::class, 'show_blog_section'])
            ->where('blog_section_name', '.*')
            ->defaults('site_locale', 'ru')
            ->name('show_blog_section');
        Route::post('/add-comment', [BlogController::class, 'add_comment'])
            ->middleware('throttle:comments')
            ->defaults('site_locale', 'ru')
            ->name('add_comment_post');
        Route::post('/article-feedback', [ArticleFeedbackController::class, 'store'])
            ->middleware('throttle:60,1')
            ->defaults('site_locale', 'ru')
            ->name('article_feedback_store');
        Route::post('/add-subscriber', [BlogController::class, 'add_subscriber'])
            ->middleware('throttle:subscribers')
            ->defaults('site_locale', 'ru')
            ->name('add_subscriber');
        Route::get('/confirm-subscriber-{hash}', [BlogController::class, 'confirmed_subscriber'])->defaults('site_locale', 'ru')->name('confirmed_subscriber');
        Route::get('/unsubscribe-comment-notifications', [BlogController::class, 'unsubscribe_comment_notifications'])->defaults('site_locale', 'ru')->name('unsubscribe_comment_notifications');
        Route::get('/unsubscribe-mailing-{hash}', [BlogController::class, 'unsubscribe_mailing'])->defaults('site_locale', 'ru')->name('unsubscribe_mailing');
    }
);

Route::group([
    'prefix' => 'en',
    'as' => 'en.blog.',
],
    function () {
        Route::get('/article_layout', [BlogController::class, 'show_article_layout'])
            ->defaults('site_locale', 'en')
            ->name('show_article_layout');
        Route::get('/blog', [BlogController::class, 'show'])
            ->defaults('site_locale', 'en')
            ->name('blog');
        Route::get('/sitemap.xml', [BlogController::class, 'sitemap'])
            ->defaults('site_locale', 'en')
            ->name('sitemap');
        Route::get('/article_{article_text_url}', [BlogController::class, 'show_article'])
            ->defaults('site_locale', 'en')
            ->name('show_article');
        Route::get('/blog_section_{blog_section_name}', [BlogController::class, 'show_blog_section'])
            ->where('blog_section_name', '.*')
            ->defaults('site_locale', 'en')
            ->name('show_blog_section');
        Route::post('/add-comment', [BlogController::class, 'add_comment'])
            ->middleware('throttle:comments')
            ->defaults('site_locale', 'en')
            ->name('add_comment_post');
        Route::post('/article-feedback', [ArticleFeedbackController::class, 'store'])
            ->middleware('throttle:60,1')
            ->defaults('site_locale', 'en')
            ->name('article_feedback_store');
        Route::post('/add-subscriber', [BlogController::class, 'add_subscriber'])
            ->middleware('throttle:subscribers')
            ->defaults('site_locale', 'en')
            ->name('add_subscriber');
        Route::get('/confirm-subscriber-{hash}', [BlogController::class, 'confirmed_subscriber'])
            ->defaults('site_locale', 'en')
            ->name('confirmed_subscriber');
        Route::get('/unsubscribe-comment-notifications', [BlogController::class, 'unsubscribe_comment_notifications'])
            ->defaults('site_locale', 'en')
            ->name('unsubscribe_comment_notifications');
        Route::get('/unsubscribe-mailing-{hash}', [BlogController::class, 'unsubscribe_mailing'])
            ->defaults('site_locale', 'en')
            ->name('unsubscribe_mailing');
    }
);

Route::group([
    'as' => 'static_pages.'
],
    function () {
        Route::get('/', function () use ($randomHeroArticleRedirect) {
            $countryCode =
                request()->server('GEOIP2_COUNTRY_CODE')
                ?? request()->server('GEOIP_COUNTRY_CODE')
                ?? request()->header('CF-IPCountry')
                ?? request()->header('X-Country-Code')
                ?? request()->server('HTTP_CF_IPCOUNTRY');

            $preferredLocale = SiteLocale::preferred(
                request(),
                is_string($countryCode) ? strtoupper(trim($countryCode)) : null
            );

            if ($preferredLocale === SiteLocale::EN) {
                return $randomHeroArticleRedirect(SiteLocale::EN);
            }

            return $randomHeroArticleRedirect(SiteLocale::RU);
        })->defaults('site_locale', 'ru')->name('home');
        Route::get('/about_me', [StaticController::class, 'about_me'])->defaults('site_locale', 'ru')->name('about_me');
        Route::get('/about_company', [StaticController::class, 'about_company'])->defaults('site_locale', 'ru')->name('about_company');
        Route::get('/contact', [StaticController::class, 'contact'])->defaults('site_locale', 'ru')->name('contact');
        Route::post('/contact', [StaticController::class, 'contact_submit'])->defaults('site_locale', 'ru')->name('contact_submit');
        Route::get('/economy-sim', [EconomySimController::class, 'show'])->defaults('site_locale', 'ru')->name('economy_sim');
    }
);

Route::group([
    'prefix' => 'en',
    'as' => 'en.static_pages.'
],
    function () use ($randomHeroArticleRedirect) {
        Route::get('/', fn () => $randomHeroArticleRedirect(SiteLocale::EN))
            ->defaults('site_locale', 'en')
            ->name('home');
        Route::get('/about_me', [StaticController::class, 'about_me'])->defaults('site_locale', 'en')->name('about_me');
        Route::get('/about_company', [StaticController::class, 'about_company'])->defaults('site_locale', 'en')->name('about_company');
        Route::get('/contact', [StaticController::class, 'contact'])->defaults('site_locale', 'en')->name('contact');
        Route::post('/contact', [StaticController::class, 'contact_submit'])->defaults('site_locale', 'en')->name('contact_submit');
        Route::get('/economy-sim', [EconomySimController::class, 'show'])->defaults('site_locale', 'en')->name('economy_sim');
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
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'],
], function () {
    Route::get('/', [AdminController::class, 'index'])
        ->name('index');
    Route::get('/article-feedback', [AdminArticleFeedbackController::class, 'index'])
        ->name('article_feedback.index');
    Route::get('/mailing-subscribers', [AdminMailingSubscriberController::class, 'index'])
        ->name('mailing_subscribers.index');
});

Route::group([
    'as' => 'utility.'
],
    function () {
        Route::get('/confirm_subscriber_{email}', [BlogController::class, 'confirm_subscriber'])
            ->defaults('site_locale', 'ru')
            ->name('confirm_subscriber');
    }
);

Route::group([
    'prefix' => 'en',
    'as' => 'en.utility.'
],
    function () {
        Route::get('/confirm_subscriber_{email}', [BlogController::class, 'confirm_subscriber'])
            ->defaults('site_locale', 'en')
            ->name('confirm_subscriber');
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
        Route::get('/terms-of-use', [DocsController::class, 'show_terms_of_use'])->defaults('site_locale', 'ru')->name('terms_of_use');
    }
);

Route::group([
    'prefix' => 'en',
    'as' => 'en.docs.'
],
    function () {
        Route::get('/terms-of-use', [DocsController::class, 'show_terms_of_use'])
            ->defaults('site_locale', 'en')
            ->name('terms_of_use');
    }
);

// Preview черновиков статей
Route::get('/drafts/{text_url}', [DraftController::class, 'preview'])->name('draft.preview');
Route::get('/en/drafts/{text_url}', [DraftController::class, 'preview'])
    ->defaults('site_locale', 'en')
    ->name('en.draft.preview');


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
