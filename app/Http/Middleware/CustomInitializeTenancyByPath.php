<?php

namespace App\Http\Middleware;

use Stancl\Tenancy\Tenancy;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Stancl\Tenancy\Resolvers\PathTenantResolver;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByPathException;

class CustomInitializeTenancyByPath extends \Stancl\Tenancy\Middleware\InitializeTenancyByPath
{
    /** @var callable|null */
    public static $onFail;

    /** @var Tenancy */
    protected $tenancy;

    /** @var PathTenantResolver */
    protected $resolver;

    public function __construct(Tenancy $tenancy, PathTenantResolver $resolver)
    {
        $this->tenancy = $tenancy;
        $this->resolver = $resolver;

        static::$onFail = fn (\Exception $e, \Illuminate\Http\Request $request, \Closure $next) => static::onFailHandler($e, $request, $next);
    }

    public function initializeTenancy($request, $next, ...$resolverArguments)
    {
        try {
            $this->tenancy->initialize(
                $this->resolver->resolve(...$resolverArguments)
            );
        } catch (TenantCouldNotBeIdentifiedException $e) {
            $onFail = static::$onFail ?? function ($e) {
                throw $e;
            };

            return $onFail($e, $request, $next);
        }

        return $next($request);
    }

    /**
     * onFailHandler function
     * Handler of error
     *
     * @param  \Exception $exception
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public static function onFailHandler(
        \Exception $exception,
        \Illuminate\Http\Request $request,
        \Closure $next
    ): mixed {
        if (!is_a($exception, TenantCouldNotBeIdentifiedByPathException::class)) {
            throw $exception;
        }

        abort(404);

        // if (in_array($request->getHost(), config('tenancy.central_domains'))) {
        //     tenancy()?->end();
        //     return static::handleNext($request, $next);
        // }

        // $onFail = static::$onFail ?? function ($e) {
        //     throw $e;
        // };

        // return $onFail($exception, $request, $next);
    }

    public static function handleNext(
        \Illuminate\Http\Request $request,
        \Closure $next,
    ): mixed {
        $uri = parse_url($request->getUri(), PHP_URL_PATH) ?: $request->getPathInfo();

        if (
            !in_array($request->getHost(), config('tenancy.central_domains'))
        ) {
            return $next($request);
        }

        $tenant = tenant();

        $routeName = \Route::currentRouteName();
        // $request->getHost(),

        $isATenantRoute = collect([
            'tenant_domain.',
            'tenant.',
            'tenant.central_domain.',
        ])->filter(fn ($prefix) => str_starts_with(
            $routeName,
            $prefix
        ))->count() > 0;

        if ($isATenantRoute && !$tenant) {
            return !in_array($uri, ['/', parse_url(route('web.home'), PHP_URL_PATH)]) ? redirect()->route('web.home') : $next($request);
        }

        if (!in_array($uri, ['/', parse_url(route('web.home'), PHP_URL_PATH)])) {
            return redirect()->route('web.home');
        }

        return $next($request);
    }
}
