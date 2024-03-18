<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BannerSlide;

class BannerSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('banner_slides')->delete();

        \DB::table('banner_slides')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Join Us',
                'body' => 'Lorem ipsum dolor Banner Slide One sit amet Banner Slide One, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'banner-slide.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/banner_slides/banner-slide.jpg',
                'link' => 'contact',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Courses and Programs',
                'body' => 'Lorem ipsum dolor Banner Slide Two sit amet Banner Slide Two, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'banner-slide2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/banner_slides/banner-slide2.jpg',
                'link' => 'courses-and-programs',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Virtual Tour',
                'body' => 'Lorem ipsum dolor Banner Slide Three sit amet Banner Slide Three, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'banner-slide.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/banner_slides/banner-slide.jpg',
                'link' => 'virtual-tour',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'title' => 'About Us',
                'body' => 'Lorem ipsum dolor Banner Slide Four sit amet Banner Slide Four, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'banner-slide2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/banner_slides/banner-slide2.jpg',
                'link' => 'about',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
    }
}
