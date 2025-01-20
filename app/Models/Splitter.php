<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Splitter extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'customer_id',
        'amount',
        'new_bets_id'
    ];

    /**
     * Get the customer that owns the bets.
     */
    public function newBet(): BelongsTo
    {
        return $this->belongsTo(NewBet::class, 'new_bets_id');
    }

    /**
     * Get the all bets for the customer.
     */
    public function new_bets(): HasMany
    {
        return $this->hasMany(NewBet::class, 'customer_id');
    }
}
