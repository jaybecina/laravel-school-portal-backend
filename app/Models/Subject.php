<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'subject_code',
        'name', 
        'start_time',
        'end_time',
        'day',
        'prereq_subject_code',
        'prereq_name', 
        'room_no',
        'units',
        'detail',
        'teacher'
    ];

    // public function curricula()
    // {
    //     return $this->belongsToMany(Curriculum::class, 'course_curriculum_subject')->withTimestamps();
    // }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'curriculum_pivot', 'subject_id', 'course_id')->withTimestamps();
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollment_pivot')
        ->withTimestamps(); 
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
