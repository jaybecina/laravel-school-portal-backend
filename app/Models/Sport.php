<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'imagename',
        'path',
        'is_active',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'sport_pivot', 'sport_id', 'user_id')
        ->withTimestamps();
    }
}
