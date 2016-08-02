<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'expired_at'
    ];

    protected $dates = ['expired_at'];

    protected $appends = ['expired'];

    protected $casts = [
        'expired_at' => 'datetime',
        'expired' => 'boolean'
    ];

    public function getExpiredAttribute()
    {
        return $this->expired_at && $this->expired_at->lt(Carbon::now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('expired_at')->orWhere('expired_at', '>', Carbon::now()->toDateTimeString());
    }
}
