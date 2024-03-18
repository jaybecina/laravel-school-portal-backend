<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EnrollmentPivot extends Pivot
{
    use HasFactory;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'curriculum_pivot', 'curriculum_id', 'course_id')
        ->withPivot('subject_id')
        ->withTimestamps();
    }
}
