<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
// use Illuminate\Support\Facades\Storage;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $imageUrl2 = asset('storage/image/events/sample-events2.jpg');

        $imageUrl = url('') . 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/sample-events.jpg';
        $imageUrl2 = url('') . 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/image/events/sample-events2.jpg';

        \DB::table('events')->delete();

        \DB::table('events')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Event One',
                'details' => 'Lorem ipsum dolor Event One sit amet Event One, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-events.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/sample-events.jpg',
                'start_date' => '2023-11-17 13:14:15',
                'end_date' => '2023-11-17 14:14:15',
                'speaker_name' => 'Speaker Name One',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Event Two',
                'details' => 'Lorem ipsum dolor Event Two sit amet Event Two, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-events2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/sample-events.jpg',
                'start_date' => '2023-11-20 13:14:15',
                'end_date' => '2023-11-20 14:14:15',
                'speaker_name' => 'Speaker Name Two',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Event Three',
                'details' => 'Lorem ipsum dolor Event Three sit amet Event Three, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-events.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/sample-events.jpg',
                'start_date' => '2023-11-17 13:14:15',
                'end_date' => '2023-11-17 14:14:15',
                'speaker_name' => 'Speaker Name Three',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Event Four',
                'details' => 'Lorem ipsum dolor Event Four sit amet Event Four, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-events2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/sample-events.jpg',
                'start_date' => '2023-11-20 13:14:15',
                'end_date' => '2023-11-20 14:14:15',
                'speaker_name' => 'Speaker Name Four',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
    }
}
