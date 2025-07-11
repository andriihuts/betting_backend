<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureType extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedure_type',
    ];

    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }
}
