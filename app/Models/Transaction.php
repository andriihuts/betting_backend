<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;    
    protected $fillable = [
        'id',
        'amount',
        'type_money',
        'customer_name',
        'type_net',
        'description'
    ];
}
