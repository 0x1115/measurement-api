<?php

namespace App\Providers;

use App\Token;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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

        \Gate::define('read-device-measurements', function ($user, $device) {
            if (!$device->user_id) {
                return true;
            }
            return $user->id === $device->user_id;
        });

        \Gate::define('store-device-measurements', function ($user, $device) {
            if (!$device->user_id) {
                return true;
            }
            return $user->id === $device->user_id;
        });

        \Gate::define('update-device-measurements', function ($user, $device) {
            if (!$device->user_id) {
                return true;
            }
            return $user->id === $device->user_id;
        });

        \Gate::define('update-device', function ($user, $device) {
            if (!$device->user_id) {
                return true;
            }
            return $user->id === $device->user_id;
        });

        \Gate::define('destroy-device', function ($user, $device) {
            if (!$device->user_id) {
                return true;
            }
            return $user->id === $device->user_id;
        });

        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $this->getToken($request);
            try {
                $token = Token::whereContent($token)->firstOrFail();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return null;
            }
            if ($token->expired) {
                abort(401, 'Expired token');
            }

            return $token->user;
        });
    }

    protected function bearerToken(\Illuminate\Http\Request $request)
    {
        $header = $request->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    protected function getToken(\Illuminate\Http\Request $request)
    {
        $token = $request->input('api_token');

        if (empty($token)) {
            $token = $this->bearerToken($request);
        }

        return $token;
    }
}