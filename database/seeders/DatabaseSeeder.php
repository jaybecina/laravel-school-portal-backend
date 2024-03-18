<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CurriculumSeeder::class);
        $this->call(EnrollmentSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(ClubSeeder::class);
        $this->call(SportSeeder::class);
        $this->call(AcademicCalendarSeeder::class);
        $this->call(VirtualTourSeeder::class);
        $this->call(AboutSeeder::class);
        $this->call(BannerSlideSeeder::class);
        $this->call(TestimonialSeeder::class);
        
        Model::reguard();
    }
}
