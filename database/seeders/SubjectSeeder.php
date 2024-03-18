<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve users with the "teacher" role
        $teachers = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Teacher');
            }
        )->get();

        // Shuffle the collection of "teacher" users to get random data
        $randomTeacher = $teachers->shuffle()->take(1)->pluck('id')->first(); // Adjust the number as needed
        $randomTeacher2 = $teachers->shuffle()->take(1)->pluck('id')->first(); 
        $randomTeacher3 = $teachers->shuffle()->take(1)->pluck('id')->first(); 
        $randomTeacher4 = $teachers->shuffle()->take(1)->pluck('id')->first(); 
        $randomTeacher5 = $teachers->shuffle()->take(1)->pluck('id')->first();
        $randomTeacher6 = $teachers->shuffle()->take(1)->pluck('id')->first();
        $randomTeacher7 = $teachers->shuffle()->take(1)->pluck('id')->first();
        $randomTeacher8 = $teachers->shuffle()->take(1)->pluck('id')->first();

        \DB::table('subjects')->delete();

        \DB::table('subjects')->insert(array (
            0 =>
            array (
                'id' => 1,
                'subject_code' => 'Math101',
                'name' => 'Algebra',
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => '',
                'prereq_name' => '',
                'room_no' => 'RM101',
                'units' => 5,
                'detail' => 'This is algebra',
                'teacher_id' => $randomTeacher,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'subject_code' => 'Math102',
                'name' => 'Discrete Math',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => 'Math101',
                'prereq_name' => 'Algebra',
                'room_no' => 'RM102',
                'units' => 5,
                'detail' => 'This is discrete math',
                'teacher_id' => $randomTeacher2,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'subject_code' => 'Math103',
                'name' => 'Trigonometry',
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => 'Math102',
                'prereq_name' => 'Discrete Math',
                'room_no' => 'RM103',
                'units' => 5,
                'detail' => 'This is discrete math',
                'teacher_id' => $randomTeacher3,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'subject_code' => 'Math104',
                'name' => 'Logical Math',
                'start_time' => '11:00:00',
                'end_time' => '12:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => 'Math104',
                'prereq_name' => 'Trigonometry',
                'room_no' => 'RM104',
                'units' => 5,
                'detail' => 'This is Logical Math',
                'teacher_id' => $randomTeacher4,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            4 =>
            array (
                'id' => 5,
                'subject_code' => 'CoPro101',
                'name' => 'Basic Computer Programming Fundamentals',
                'start_time' => '13:00:00',
                'end_time' => '14:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => '',
                'prereq_name' => '',
                'room_no' => 'RM101',
                'units' => 5,
                'detail' => 'This is basic computer programming fundamentals',
                'teacher_id' => $randomTeacher5,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            5 =>
            array (
                'id' => 6,
                'subject_code' => 'CoPro102',
                'name' => 'Object Oriented Programming',
                'start_time' => '14:00:00',
                'end_time' => '15:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => 'CoPro101',
                'prereq_name' => 'Basic Computer Programming Fundamentals',
                'room_no' => 'RM102',
                'units' => 5,
                'detail' => 'This is object oriented programming',
                'teacher_id' => $randomTeacher6,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            6 =>
            array (
                'id' => 7,
                'subject_code' => 'CoPro103',
                'name' => 'Basic Frontend Web Development',
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => 'CoPro102',
                'prereq_name' => 'Object Oriented Programming',
                'room_no' => 'RM103',
                'units' => 5,
                'detail' => 'This is basic frontend web development',
                'teacher_id' => $randomTeacher7,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            7 =>
            array (
                'id' => 8,
                'subject_code' => 'CoPro104',
                'name' => 'Basic Backend Web Development',
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
                'day' => \Carbon\Carbon::now(),
                'prereq_subject_code' => 'CoPro103',
                'prereq_name' => 'Frontend Web Development',
                'room_no' => 'RM104',
                'units' => 5,
                'detail' => 'This is basic backend web development',
                'teacher_id' => $randomTeacher8,
                'is_prereq' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
    }
}
