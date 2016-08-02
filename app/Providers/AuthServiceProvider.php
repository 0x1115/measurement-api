<?php

namespace App\Providers;

use App\Token;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                $token = Token::whereContent($request->input('api_token'))->first();
                if (!$token) {
                    return null;
                }
                if ($token->expired) {
                    abort(401, 'Expired token');
                }
                return Token::whereContent($request->input('api_token'))->active()->firstOrFail()->device;
            }
        });
    }
}
