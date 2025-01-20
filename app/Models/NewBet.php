<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewBet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'slip',
        'odds',
        'live',
        'amount',
        'splitters',
        'status',
        'bsplitter',
        'currency',
        'notes',
        'rate'
    ];
    /**
     * Get the customer that owns the bets.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the specified bets's splitters.
     */
    public function bet_splitters(): HasMany
    {
        return $this->hasMany(Splitter::class, 'new_bets_id');
    }
}
