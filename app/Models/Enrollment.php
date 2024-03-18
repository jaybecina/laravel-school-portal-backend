<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_code',
        'name',
        'remarks',
        'status',
    ];

    public function curricula()
    {
        return $this->belongsToMany(Curriculum::class, 'enrollment_pivot', 'enrollment_id', 'curriculum_id')
        ->withPivot('course_id', 'subject_id')
        // ->using(EnrollmentPivot::class)
        ->withTimestamps();
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
