<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
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
        return $this->belongsToMany(User::class, 'club_pivot', 'club_id', 'user_id')
        ->withTimestamps();
    }
}
