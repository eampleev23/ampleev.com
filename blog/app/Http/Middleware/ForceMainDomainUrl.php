<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceMainDomainUrl
{
    /**
     * Handle an incoming request.
     * 
     * Если запрос идет с поддомена pointscounter.ampleev.com,
     * устанавливаем базовый URL на основной домен ampleev.com
     * для генерации правильных ссылок в меню.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Если запрос идет с поддомена pointscounter.ampleev.com
        if ($host === 'pointscounter.ampleev.com') {
            // Устанавливаем базовый URL на основной домен
            URL::forceRootUrl('https://ampleev.com');
            URL::forceScheme('https');
        }
        
        return $next($request);
    }
}

