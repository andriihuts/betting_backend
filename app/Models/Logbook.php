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
        'procedure_type',
        'role',
        'notes',
        'attachment_path',
        'procedure_type_id',
        'hospital_id',
    ];

    protected $casts = [
        'dob' => 'date',
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

    public function getProcedureDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDobAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
