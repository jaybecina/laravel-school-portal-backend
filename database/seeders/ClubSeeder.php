<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Club;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ClubSeeder extends Seeder
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

        $imageUrl = url('') . 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/sample-club.jpg';
        $imageUrl2 = url('') . 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/image/events/sample-club2.jpg';

        \DB::table('clubs')->delete();

        \DB::table('clubs')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Club One',
                'details' => 'Lorem ipsum dolor Club One sit amet Club One, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-club.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/clubs/sample-club.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Club Two',
                'details' => 'Lorem ipsum dolor Club Two sit amet Club Two, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-club2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/clubs/sample-club2.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Club Three',
                'details' => 'Lorem ipsum dolor Club Three sit amet Club Three, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-club.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/clubs/sample-club.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Club Four',
                'details' => 'Lorem ipsum dolor Club Four sit amet Club Four, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-club2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/clubs/sample-club2.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));

        $i = 0;
        $student = null;
        foreach(Club::all() as $club) {
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

            $club->students()->attach($student);
        }
    }
}
