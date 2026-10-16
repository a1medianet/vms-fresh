<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'nationality',
        'passport_number',
        'arrival_date',
        'departure_date',
        'status',
        'pre_arrival_id',
    ];

    protected function casts(): array
    {
        return [
            'arrival_date' => 'date',
            'departure_date' => 'date',
        ];
    }

    public function preArrival(): BelongsTo
    {
        return $this->belongsTo(PreArrival::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function currentAssignment(): ?Assignment
    {
        return $this->assignments()
            ->whereNull('check_out_at')
            ->latest('check_in_at')
            ->first();
    }
}
