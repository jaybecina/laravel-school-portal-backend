<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Subject;
use Spatie\Permission\Models\Role;
use App\Models\User;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $totalCredits = 30;
        $currentCredits = 0;


        // Retrieve users with the "student" role
        $students = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Student');
            }
        )->get();

        // Shuffle the collection of "student" users to get random data
        $randomStudent = $students->shuffle()->take(1)->pluck('id')->first(); // Adjust the number as needed
        $randomStudent2 = $students->shuffle()->take(1)->pluck('id')->first(); 
        $randomStudent3 = $students->shuffle()->take(1)->pluck('id')->first(); 
        $randomStudent4 = $students->shuffle()->take(1)->pluck('id')->first(); 


        // School year
        $currentYear = date('Y');
        $school_year = $currentYear . "-" . ($currentYear + 1);
        $school_year2 = ($currentYear - 1) . "-" . ($currentYear);
        $school_year3 = $currentYear - 2 . "-" . ($currentYear - 1);
        $school_year4 = $currentYear . "-" . ($currentYear + 1);
        

        \DB::table('enrollments')->delete();

        \DB::table('enrollments')->insert(array (
            0 =>
            array (
                'id' => 1,
                'enrollment_code' => 'ENRL1STSEM2023-1',
                'student_id' => $randomStudent,
                'remarks' => 'This is enrollment 1',
                'school_year' => $school_year,
                'sem' => '1st Sem',
                'credits' => $totalCredits,
                'status' => 'Active',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'enrollment_code' => 'ENRL1STSEM2023-2',
                'student_id' => $randomStudent2,
                'remarks' => 'This is enrollment 2',
                'school_year' => $school_year2,
                'sem' => '1st Sem',
                'credits' => $totalCredits,
                'status' => 'Transferred',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'enrollment_code' => 'ENRL1STSEM2023-3',
                'student_id' => $randomStudent3,
                'remarks' => 'This is enrollment 3',
                'school_year' => $school_year3,
                'sem' => '1st Sem',
                'credits' => $totalCredits,
                'status' => 'Inactive',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'enrollment_code' => 'ENRL1STSEM2023-4',
                'student_id' => $randomStudent4,
                'remarks' => 'This is enrollment 4',
                'school_year' => $school_year4,
                'sem' => '1st Sem',
                'credits' => $totalCredits,
                'status' => 'Blacklisted',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));

        foreach(Enrollment::all() as $enrollment) {
            // $courses = \App\Models\Course::inRandomOrder()->take(rand(1, 3))->pluck('id');
            // $curriculum->courses()->attach($courses);

            $currentCredits = 0;

            $curriculum = Curriculum::inRandomOrder()->first();

            $course = Course::inRandomOrder()->first();
            
            // credits total of 30 each units 5 in this seeder
            $subjects = Subject::inRandomOrder()->limit(6)->get();

            // // Find the "student" role
            // $studentRole = Role::where('name', 'student')->first();

            // // Get all users with the "student" role
            // $student = User::role($studentRole)->inRandomOrder()->first();


            foreach($subjects as $subject) {
                if($currentCredits <= $totalCredits) {
                    $enrollment->curricula()->attach($curriculum->id, [
                        'course_id' => $course->id,
                        'subject_id'  => $subject->id,
                    ]);
                    $currentCredits += $subject->units;
                }
            }
        }
    }
}
