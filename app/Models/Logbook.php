<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_name',
        'mrn',
        'dob',
        'procedure_date',
        'role',
        'notes',
        'procedure_type_id',
        'hospital_id',
    ];

    protected $casts = [
        'procedure_date' => 'date',
    ];
    
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
    
    public function procedure_type()
    {
        return $this->belongsTo(ProcedureType::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getProcedureDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
