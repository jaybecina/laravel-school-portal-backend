<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('testimonials')->delete();

        \DB::table('testimonials')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Testimonial One',
                'body' => 'Lorem ipsum dolor Testimonial One sit amet Testimonial One, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-testimonial.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/testimonials/sample-testimonial.jpg',
                'name' => 'Name One',
                'job' => 'Teacher',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Testimonial Two',
                'body' => 'Lorem ipsum dolor Testimonial Two sit amet Testimonial Two, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-testimonial2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/testimonials/sample-testimonial2.jpg',
                'name' => 'Name Two',
                'job' => 'Nurse',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Testimonial Three',
                'body' => 'Lorem ipsum dolor Testimonial Three sit amet Testimonial Three, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-testimonial3.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/testimonials/sample-testimonial3.jpg',
                'name' => 'Name Three',
                'job' => '',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'title' => 'Testimonial Four',
                'body' => 'Lorem ipsum dolor Testimonial Four sit amet Testimonial Four, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-testimonial4.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/testimonials/sample-testimonial4.jpg',
                'name' => 'Name Four',
                'job' => 'Nurse',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
    }
}
