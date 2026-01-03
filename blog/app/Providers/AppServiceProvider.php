<?php

namespace App\Providers;

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
        View::share('country_code', $countryCode);
        View::share('is_ru', $countryCode === 'RU');
        
        \Log::info('AppServiceProvider::boot() called');
        
        // Проверяем, существует ли класс YandexExtendSocialite
        if (class_exists(YandexExtendSocialite::class)) {
            \Log::info('YandexExtendSocialite class exists');
        } else {
            \Log::error('YandexExtendSocialite class NOT found');
        }
        
        // Проверяем, существует ли класс SocialiteWasCalled
        if (class_exists(SocialiteWasCalled::class)) {
            \Log::info('SocialiteWasCalled class exists');
        } else {
            \Log::error('SocialiteWasCalled class NOT found');
        }
        
        // Регистрация провайдера Yandex для Laravel Socialite через событие
        Event::listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
            \Log::info('SocialiteWasCalled event fired in AppServiceProvider');
            try {
                $extender = new YandexExtendSocialite();
                $extender->handle($event);
                \Log::info('YandexExtendSocialite::handle() called successfully');
            } catch (\Exception $e) {
                \Log::error('Error in YandexExtendSocialite::handle(): ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        });
        
        // Также регистрируем напрямую через Socialite::extend() для надежности
        $this->app->booted(function () {
            \Log::info('App booted, attempting direct registration of Yandex provider');
            try {
                $config = config('services.yandex');
                if ($config) {
                    \Log::info('Yandex config found: ' . json_encode(array_keys($config)));
                    Socialite::extend('yandex', function ($app) use ($config) {
                        \Log::info('Socialite::extend("yandex") callback called');
                        return Socialite::buildProvider(
                            \SocialiteProviders\Yandex\Provider::class,
                            $config
                        );
                    });
                    \Log::info('Yandex provider registered directly via Socialite::extend()');
                } else {
                    \Log::error('Yandex config not found in config/services.php');
                }
            } catch (\Exception $e) {
                \Log::error('Error in direct Yandex provider registration: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        });
        
        \Log::info('AppServiceProvider::boot() completed');
    }
}
