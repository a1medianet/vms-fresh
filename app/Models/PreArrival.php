<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class PreArrival extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'arrival_date' => 'date',
            'departure_date' => 'date',
            'used_at' => 'datetime',
        ];
    }

    public static function generateToken(): string
    {
        return Str::random(64);
    }

    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    public function visitor(): HasOne
    {
        return $this->hasOne(Visitor::class);
    }
}
