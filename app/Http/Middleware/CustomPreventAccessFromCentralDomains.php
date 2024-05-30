<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class CustomPreventAccessFromCentralDomains extends PreventAccessFromCentralDomains
{
    /**
     * Set this property if you want to customize the on-fail behavior.
     *
     * @var callable|null
     */
    public static $abortRequest;

    public function __construct(...$params)
    {
        static::$abortRequest = function (?Request $request = null, ?Closure $next = null) {
            if (tenant()?->domains()?->where('domain', $request->getHost())?->exists()) {
                return $next($request);
            }

            abort(404);
        };
    }

    public function handle(Request $request, Closure $next)
    {
        if (!tenant() && in_array($request->getHost(), config('tenancy.central_domains')) || tenant()) {
            return $next($request);
        }

        $abortRequest = static::$abortRequest ?? function (?Request $request = null, ?Closure $next = null) {
            abort(404);
        };

        return $abortRequest($request, $next);
    }
}
