<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'humidity', 'temperature', 'device_id'
    ];

    protected $casts = [
        'humidity' => 'double',
        'temperature' => 'integer'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
