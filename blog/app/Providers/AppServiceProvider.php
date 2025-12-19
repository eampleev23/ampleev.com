<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Yandex\Provider;

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

        // Регистрируем провайдер Yandex напрямую через Socialite
        $this->app->booted(function () {
            \Log::info('App booted, registering Yandex provider directly');
            
            // Регистрируем через событие (для совместимости)
            Event::listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
                \Log::info('SocialiteWasCalled event fired');
                $event->extendSocialite('yandex', Provider::class);
                \Log::info('Yandex provider extended via event');
            });
            
            // Регистрируем напрямую через Socialite::extend()
            try {
                $config = config('services.yandex');
                Socialite::extend('yandex', function ($app) use ($config) {
                    return Socialite::buildProvider(Provider::class, $config);
                });
                \Log::info('Yandex provider extended directly via Socialite::extend()');
            } catch (\Exception $e) {
                \Log::error('Failed to register Yandex provider directly: ' . $e->getMessage());
            }
            
            \Log::info('Yandex provider registration completed');
        });
    }
}
