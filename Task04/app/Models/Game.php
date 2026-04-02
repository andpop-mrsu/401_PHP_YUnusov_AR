<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'number',
        'is_prime',
        'user_answer',
        'is_correct',
        'divisors',
        'played_at',
    ];

    protected $casts = [
        'is_prime'  => 'boolean',
        'is_correct' => 'boolean',
        'played_at' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Человекочитаемый ответ пользователя.
     */
    public function getUserAnswerLabelAttribute(): string
    {
        return $this->user_answer === 'prime' ? 'Простое' : 'Составное';
    }
}
