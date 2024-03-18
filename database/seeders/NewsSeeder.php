<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('news')->delete();

        \DB::table('news')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'News One',
                'body' => 'Lorem ipsum dolor News One sit amet News One, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-news.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/news/sample-news.jpg',
                'author' => 'Author Name One',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'News Two',
                'body' => 'Lorem ipsum dolor News Two sit amet News Two, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-news2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/news/sample-news2.jpg',
                'author' => 'Author Name Two',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'News Three',
                'body' => 'Lorem ipsum dolor News Three sit amet News Three, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-news.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/news/sample-news.jpg',
                'author' => 'Author Name Three',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
            3 =>
            array (
                'id' => 4,
                'title' => 'News Four',
                'body' => 'Lorem ipsum dolor News Four sit amet News Four, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'imagename' => 'sample-news2.jpg',
                'path' => 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/news/sample-news2.jpg',
                'author' => 'Author Name Four',
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
    }
}
