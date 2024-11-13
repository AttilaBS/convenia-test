<?php

namespace App\Providers;

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
                    logger()->info('Foi excedido o número máximo de tentativas pelo usuário:', [
                        'email: ' => $request->input('email'),
                        'ip: ' => $request->ip(),
                    ]);

                    return response()->json(
                        [
                            'message' => 'O número máximo de tentativas foi excedido. Favor tentar novamente em alguns minutos',
                            'status' => 429,
                        ],
                    );
                }
            );
        });
    }
}
