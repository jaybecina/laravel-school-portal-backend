<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'curriculum_code',
        'name',
        'desc',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'curriculum_pivot', 'curriculum_id', 'course_id')
        ->withPivot('subject_id')
        ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class, 'enrollment_pivot', 'curriculum_id', 'enrollment_id')
        ->withTimestamps();
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollment_pivot', 'curriculum_id', 'course_id')
        ->withPivot('subject_id')
        ->withTimestamps();
    }
}
