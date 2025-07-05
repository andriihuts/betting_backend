<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'logbook_id',
    ];

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }
}
