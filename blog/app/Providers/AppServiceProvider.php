<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
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

        // Регистрируем провайдер Yandex через событие
        // Используем booted() чтобы убедиться, что все сервисы загружены
        $this->app->booted(function () {
            \Log::info('App booted, registering Yandex provider');
            
            Event::listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
                \Log::info('SocialiteWasCalled event fired', [
                    'driver' => method_exists($event, 'getDriver') ? $event->getDriver() : 'unknown'
                ]);
                $event->extendSocialite('yandex', Provider::class);
                \Log::info('Yandex provider extended');
            });
            
            \Log::info('Yandex provider event listener registered');
        });
    }
}
