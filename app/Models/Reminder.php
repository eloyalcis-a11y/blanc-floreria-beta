<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'title',
        'reminder_date',
        'frequency',
        'notes',
    ];
    
    protected $casts = [
        'reminder_date' => 'date',
    ];
}
