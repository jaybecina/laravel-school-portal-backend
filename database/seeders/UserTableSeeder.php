<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'first_name' => 'Super',
                'middle_name' => 'Admin',
                'last_name' => 'User',
                'contact_num' => '09123456789',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'first_name' => 'Sample',
                'middle_name' => 'Teacher',
                'last_name' => 'Teacher',
                'contact_num' => '09123456789',
                'email' => 'teacher@teacher.com',
                'password' => Hash::make('teacher'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'first_name' => 'Sample 2',
                'middle_name' => 'Teacher 2',
                'last_name' => 'Teacher 2',
                'contact_num' => '09123456789',
                'email' => 'teacher2@teacher.com',
                'password' => Hash::make('teacher'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'first_name' => 'Sample 3',
                'middle_name' => 'Teacher 3',
                'last_name' => 'Teacher 3',
                'contact_num' => '09123456789',
                'email' => 'teacher3@teacher.com',
                'password' => Hash::make('teacher'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            4 =>
            array (
                'id' => 5,
                'first_name' => 'Sample 4',
                'middle_name' => 'Teacher 4',
                'last_name' => 'Teacher 4',
                'contact_num' => '09123456789',
                'email' => 'teacher4@teacher.com',
                'password' => Hash::make('teacher'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            5 =>
            array (
                'id' => 6,
                'first_name' => 'Sample',
                'middle_name' => 'Student',
                'last_name' => 'Student',
                'contact_num' => '09123456789',
                'email' => 'student@student.com',
                'password' => Hash::make('student'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            6 =>
            array (
                'id' => 7,
                'first_name' => 'Sample 2',
                'middle_name' => 'Student 2',
                'last_name' => 'Student 2',
                'contact_num' => '09123456789',
                'email' => 'student2@student.com',
                'password' => Hash::make('student'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            7 =>
            array (
                'id' => 8,
                'first_name' => 'Sample 3',
                'middle_name' => 'Student 3',
                'last_name' => 'Student 3',
                'contact_num' => '09123456789',
                'email' => 'student3@student.com',
                'password' => Hash::make('student'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            8 =>
            array (
                'id' => 9,
                'first_name' => 'Sample 4',
                'middle_name' => 'Student 4',
                'last_name' => 'Student 4',
                'contact_num' => '09123456789',
                'email' => 'student4@student.com',
                'password' => Hash::make('student'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));

        // $user = User::factory()->count(50)->create();
    }
}
