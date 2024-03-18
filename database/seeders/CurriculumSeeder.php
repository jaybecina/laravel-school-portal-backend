<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Subject;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalCredits = 30;
        $currentCredits = 0;

        \DB::table('curricula')->delete();

        \DB::table('curricula')->insert(array (
            0 =>
            array (
                'id' => 1,
                'curriculum_code' => 'CRLM-1',
                'name' => 'Curriculum 1',
                'desc' => 'This is curriculum 1',
                'credits' => $totalCredits,
                'is_active' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'curriculum_code' => 'CRLM-2',
                'name' => 'Curriculum 2',
                'desc' => 'This is curriculum 2',
                'credits' => $totalCredits,
                'is_active' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'curriculum_code' => 'CRLM-3',
                'name' => 'Curriculum 3',
                'desc' => 'This is curriculum 3',
                'credits' => $totalCredits,
                'is_active' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'curriculum_code' => 'CRLM-4',
                'name' => 'Curriculum 4',
                'desc' => 'This is curriculum 4',
                'credits' => $totalCredits,
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));

        foreach(Curriculum::all() as $curriculum) {
            // $courses = \App\Models\Course::inRandomOrder()->take(rand(1, 3))->pluck('id');
            // $curriculum->courses()->attach($courses);

            $courses = Course::inRandomOrder()->take(rand(2, 4))->get();
            
            foreach($courses as $course) {
                $currentCredits = 0;

                // credits total of 30 each units 5 in this seeder
                $subjects = Subject::inRandomOrder()->limit(6)->get();
    
                foreach($subjects as $subject) {
                    if($currentCredits <= $totalCredits) {
                        $curriculum->courses()->attach($course->id, ['subject_id' => $subject->id]);
                        $currentCredits += $subject->units;
                    }
                }
            }
        }
    }
}
