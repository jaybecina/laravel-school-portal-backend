<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'imagename',
        'path',
        'start_date',
        'end_date',
        'speaker_name',
        'is_active',
    ];
}
