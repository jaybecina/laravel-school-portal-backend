<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve users with the "student" role
        $students = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Student');
            }
        )->get();

        // Shuffle the collection of "student" users to get random data
        $randomStudent1 = $students->shuffle()->take(1)->pluck('id')->first(); // Adjust the number as needed
        $randomStudent2 = $students->shuffle()->take(1)->pluck('id')->first(); 
        $randomStudent3 = $students->shuffle()->take(1)->pluck('id')->first(); 
        $randomStudent4 = $students->shuffle()->take(1)->pluck('id')->first(); 

        $imageUrl = url('') . 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/sports/sample-sports.jpg';
        $imageUrl2 = url('') . 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/image/sports/sample-sports2.jpg';

        \DB::table('sports')->delete();

        \DB::table('sports')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Sport One',
                'details' => 'Lorem ipsum dolor Sport One sit amet Sport One, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-sports.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/sports/sample-sports.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Sport Two',
                'details' => 'Lorem ipsum dolor Sport Two sit amet Sport Two, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-sports2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/sports/sample-sports2.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Sport Three',
                'details' => 'Lorem ipsum dolor Sport Three sit amet Sport Three, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-sports.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/sports/sample-sports.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Sport Four',
                'details' => 'Lorem ipsum dolor Sport Four sit amet Sport Four, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-sports2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/sports/sample-sports2.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));

        $i = 0;
        $student = null;
        foreach(Sport::all() as $sport) {
            $i++;
            switch ($i) {
                case 1:
                    $student = $randomStudent1;
                    break;

                case 2:
                    $student = $randomStudent2;
                    break;

                case 3:
                    $student = $randomStudent3;
                    break;

                case 4:
                    $student = $randomStudent4;
                    break; 
            }

            $sport->students()->attach($student);
        }
    }
}
