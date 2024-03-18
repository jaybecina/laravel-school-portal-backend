<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'course_code', 
        'title',
        'desc',
        'credits',
        'dept_code',
    ];

    public function curricula()
    {
        return $this->belongsToMany(Curriculum::class, 'curriculum_pivot', 'course_id', 'curriculum_id')
        ->withPivot('subject_id')
        ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'curriculum_pivot', 'course_id', 'subject_id')
        ->withTimestamps();
    }

    public function enrolledCurricula()
    {
        return $this->belongsToMany(Curriculum::class, 'enrollment_pivot', 'course_id', 'curriculum_id')
        ->withPivot('subject_id')
        ->withTimestamps();
    }

    public function enrolledSubjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollment_pivot', 'course_id', 'subject_id')
        ->withTimestamps();
    }
}
