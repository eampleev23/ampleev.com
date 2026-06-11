<?php

namespace App\Providers;

use App\Support\SiteLocale;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Yandex\YandexExtendSocialite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Гео-флаг для шаблонов (нужен, чтобы скрывать X/Facebook в РФ, где они заблокированы)
        // Источник кода страны (в порядке приоритета):
        // 1. Nginx GeoIP2: GEOIP2_COUNTRY_CODE (fastcgi_param) - приоритет, работает без Cloudflare
        // 2. Nginx GeoIP: GEOIP_COUNTRY_CODE (fastcgi_param) - fallback для старого GeoIP
        // 3. Cloudflare: CF-IPCountry (если используется проксирование)
        // 4. Заголовок X-Country-Code (если установлен вручную)
        $countryCode =
            request()->server('GEOIP2_COUNTRY_CODE')
            ?? request()->server('GEOIP_COUNTRY_CODE')
            ?? request()->header('CF-IPCountry')
            ?? request()->header('X-Country-Code')
            ?? request()->server('HTTP_CF_IPCOUNTRY');

        $countryCode = is_string($countryCode) ? strtoupper(trim($countryCode)) : null;
        $siteLocale = SiteLocale::resolve(request(), $countryCode);
        $localeLabels = SiteLocale::labels($siteLocale);

        View::share('country_code', $countryCode);
        View::share('is_ru', $countryCode === 'RU');
        View::share('site_locale', $siteLocale);
        View::share('locale_labels', $localeLabels);
        // locale_switch_urls нельзя считать в boot(): роут ещё не сопоставлен и
        // switchUrl() всегда уходит в fallback. Композер выполняется в момент
        // рендера шаблона, когда request()->route() уже доступен.
        View::composer('*', function ($view) {
            static $urls = null;
            $urls ??= [
                'ru' => SiteLocale::switchUrl(request(), SiteLocale::RU),
                'en' => SiteLocale::switchUrl(request(), SiteLocale::EN),
            ];
            if (!array_key_exists('locale_switch_urls', $view->getData())) {
                $view->with('locale_switch_urls', $urls);
            }
        });

        if (!class_exists(YandexExtendSocialite::class)) {
            \Log::error('YandexExtendSocialite class NOT found');
        }

        if (!class_exists(SocialiteWasCalled::class)) {
            \Log::error('SocialiteWasCalled class NOT found');
        }
        
        // Регистрация провайдера Yandex для Laravel Socialite через событие
        Event::listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
            try {
                $extender = new YandexExtendSocialite();
                $extender->handle($event);
            } catch (\Exception $e) {
                \Log::error('Error in YandexExtendSocialite::handle(): ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        });
        
        // Также регистрируем напрямую через Socialite::extend() для надежности
        $this->app->booted(function () {
            try {
                $config = config('services.yandex');
                if ($config) {
                    Socialite::extend('yandex', function ($app) use ($config) {
                        return Socialite::buildProvider(
                            \SocialiteProviders\Yandex\Provider::class,
                            $config
                        );
                    });
                } else {
                    \Log::error('Yandex config not found in config/services.php');
                }
            } catch (\Exception $e) {
                \Log::error('Error in direct Yandex provider registration: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        });
        
    }
}
