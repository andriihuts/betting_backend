<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'website_url',
        'icon_url'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }
}
