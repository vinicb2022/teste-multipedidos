<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRecord extends Model
{
    use HasFactory;

    protected $table = 'data';

    protected $casts = [
        'date' => 'datetime',
        'value' => 'decimal:2',
    ];
}