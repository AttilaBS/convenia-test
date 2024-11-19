<?php

namespace App\Providers;

use App\Http\Resources\GenericResource;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::hashClientSecrets();

        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addDays(20));
        Passport::refreshTokensExpireIn(now()->addDays(40));
        Passport::personalAccessTokensExpireIn(now()->addMonths(3));

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id
                    ? $request->user()->id
                    : $request->ip()
            );
        });

        RateLimiter::for('user', function (Request $request) {
            return Limit::perMinutes(2, 3)->by($request->ip())->response(
                function (Request $request) {
                    /** @noinspection NullPointerExceptionInspection */
                    /** @noinspection NullPointerExceptionInspection */
                    /** @noinspection NullPointerExceptionInspection */
                    logger()->info('Foi excedido o número máximo de tentativas pelo usuário:', [
                        'email: ' => $request->input('email'),
                        'ip: ' => $request->ip(),
                    ]);

                    return (new GenericResource(__('throttle.user')))->response();
                }
            );
        });
    }
}
