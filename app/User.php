<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public static function generateToken($user, $expiration, $forced = false)
    {
        // Check for previously forever created token
        if ($user->tokens()->forever()->count()) {
            if (!$forced) {
                return $user->tokens()->forever()->first();
            }
            $user->tokens()->forever()->update([
                'expired_at' => Carbon::now()
            ]);
        }
        // Should be moved to a service
        $token = Token::create([
            'content' => str_random(60),
            'expired_at' => $expiration
        ]);

        $user->tokens()->save($token);

        return $token;
    }
}
