<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('abouts')->delete();

        \DB::table('abouts')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Your Gateway to Academic Excellence',
                'body' => 'Welcome to KLL Online Portal—a comprehensive platform designed to empower students, faculty, and staff in their educational journey. At KLL Online Portal, we believe in fostering a vibrant and inclusive learning environment, and our portal system serves as the central hub for academic resources, courses and programs, academic calendar, events, clubs, sports, and administrative support. Explore a myriad of features tailored to streamline your academic experience. Students can access course materials, submit assignments, and track academic progress effortlessly. Stay updated with news, events, and academic calendars to remain informed and engaged in campus life. Join us on this digital platform and discover the boundless opportunities that await you at KLL Online Portal. Together, let us embark on a transformative educational experience that prepares you for success in a rapidly changing world.',
                'imagename' => 'sample-about.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/about/sample-about.jpg',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            )
        ));
    }
}
