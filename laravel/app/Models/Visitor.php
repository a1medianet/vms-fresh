<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CHECKED_IN = 'checked-in';
    public const STATUS_CHECKED_OUT = 'checked-out';

    protected $fillable = [
        'full_name',
        'email',
        'nationality',
        'passport_number',
        'arrival_date',
        'departure_date',
        'status',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}

