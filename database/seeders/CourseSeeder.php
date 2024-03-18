<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('courses')->delete();

        \DB::table('courses')->insert(array (
            0 =>
            array (
                'id' => 1,
                'course_code' => 'BSIT',
                'title' => 'Bachelor of Science in Information Technology',
                'desc' => 'Software/Web Development, Hardware and Network',
                'credits' => 32,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'course_code' => 'BSCS',
                'title' => 'Bachelor of Science in Computer Science',
                'desc' => 'Theoretical and Algorithm in Software and Computer Programs',
                'credits' => 34,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'course_code' => 'BSN',
                'title' => 'Bachelor of Science in Nursing',
                'desc' => 'Course about healthcare science',
                'credits' => 35,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'course_code' => 'BSBA',
                'title' => 'Bachelor of Science in Business Administration',
                'desc' => 'Course about Business Administration',
                'credits' => 33,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            4 =>
            array (
                'id' => 5,
                'course_code' => 'BSHRM',
                'title' => 'Bachelor of Science in Hospitality Management',
                'desc' => 'Course about Hospitality Management',
                'credits' => 32,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            5 =>
            array (
                'id' => 6,
                'course_code' => 'BSCOE',
                'title' => 'Bachelor of Science in Computer Engineering',
                'desc' => 'Course about Computer Engineering',
                'credits' => 34,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            6 =>
            array (
                'id' => 7,
                'course_code' => 'BSA',
                'title' => 'Bachelor of Science in Accountancy',
                'desc' => 'Course about Accountancy',
                'credits' => 35,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            7 =>
            array (
                'id' => 8,
                'course_code' => 'BSCRIM',
                'title' => 'Bachelor of Science in Criminology',
                'desc' => 'Course about Criminology',
                'credits' => 33,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));

        // foreach(Course::all() as $course) {
        //     // $courses = \App\Models\Course::inRandomOrder()->take(rand(1, 3))->pluck('id');
        //     // $curriculum->courses()->attach($courses);
            
        //     $subjects = Subject::inRandomOrder()->take(rand(1, 4))->get();

        //     $course->subjects()->attach($subjects);
        // }
    }
}
