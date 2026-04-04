<?php

namespace App\Http\Middleware;

use App\Support\SiteLocale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PersistSiteLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $countryCode =
            $request->server('GEOIP2_COUNTRY_CODE')
            ?? $request->server('GEOIP_COUNTRY_CODE')
            ?? $request->header('CF-IPCountry')
            ?? $request->header('X-Country-Code')
            ?? $request->server('HTTP_CF_IPCOUNTRY');

        $locale = SiteLocale::resolve($request, is_string($countryCode) ? strtoupper(trim($countryCode)) : null);

        cookie()->queue(cookie(
            SiteLocale::COOKIE_NAME,
            $locale,
            60 * 24 * 365,
            '/',
            null,
            $request->isSecure(),
            false,
            false,
            'lax'
        ));

        return $response;
    }
}
