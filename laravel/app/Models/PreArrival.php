<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreArrival extends Model
{
    protected $fillable = [
        'token',
        'full_name',
        'email',
        'nationality',
        'passport_number',
        'arrival_date',
        'departure_date',
        'used_at',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
        'used_at' => 'datetime',
    ];

    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }
}

