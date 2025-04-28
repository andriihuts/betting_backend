<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'a_apply_pay',
        'b_bitcoin',
        'm_game_currency',
        'c_card',
        'u_ukbt',
        'l_litecoin',        
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) {
            // Delete related new bets                        
            $customer->new_bets()->delete();
            
            // Delete related splitters
            $customer->getSplitters()->delete();
        });
    }

    /**
     * Get the new bets for the customer.
     */
    public function new_bets(): HasMany
    {
        return $this->hasMany(NewBet::class);
    }

    /**
     * Get the splitters
     */
    public function getSplitters(): HasMany
    {
        return $this->hasMany(Splitter::class);
    }
}
