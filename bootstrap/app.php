<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CustomInitializeTenancyByDomain;
use App\Http\Middleware\CustomPreventAccessFromCentralDomains;
use App\Http\Middleware\CustomInitializeTenancyByPath;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: null, //__DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            $centralDomains = config('tenancy.central_domains');

            foreach ($centralDomains as $pos => $centralDomain) {
                // Route::middleware('web')
                //     ->domain($centralDomain)
                //     ->name("tenant.domain.{$pos}.")
                //     ->group(base_path('routes/tenant-path.php'));

                Route::middleware([
                    CustomInitializeTenancyByPath::class,
                ])
                    ->domain($centralDomain)
                    ->prefix('tn/{tenant}')
                    ->name("tenant.central_domain.{$pos}.")
                    ->group(function () {
                        require base_path('routes/tenant-path.php');
                    });
            }

            Route::middleware([
                // 'web',
                CustomInitializeTenancyByDomain::class,
                CustomPreventAccessFromCentralDomains::class,
            ])->group(function () {
                Route::middleware(['web'])
                ->group(function () {
                    require base_path('routes/tenant.php');

                    require base_path('routes/web.php');

                    Route::name('tenant_domain.')->group(base_path('routes/tenant-domain.php'));

                    Route::name('web.')
                        ->prefix('_')
                        ->group(base_path('routes/web.php'));
                });
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            App\Http\Middleware\HandleInertiaRequests::class,
            Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
