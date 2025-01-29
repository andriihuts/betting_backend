<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'address',
        'background_classname'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }
}
