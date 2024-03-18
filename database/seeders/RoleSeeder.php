<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('roles')->delete();
        \DB::table('permissions')->delete();
        \DB::table('role_has_permissions')->delete();

        $super_permissions = collect([
            ['name' => 'can create'],
            ['name' => 'can read'],
            ['name' => 'can update'],
            ['name' => 'can dealete'],
        ]);

        $super_admin_role = Role::create(['name' => 'Super Admin']);
        $teacher_role = Role::create(['name' => 'Teacher']);
        $student_role = Role::create(['name' => 'Student']);


        $permission_create  = Permission::create(['name' => 'can-create']);
        $permission_read    = Permission::create(['name' => 'can-read']);
        $permission_update  = Permission::create(['name' => 'can-update']);
        $permission_delete  = Permission::create(['name' => 'can-delete']);

        // Super Admin
        $permission_create->assignRole($super_admin_role);
        $permission_read->assignRole($super_admin_role);
        $permission_update->assignRole($super_admin_role);
        $permission_delete->assignRole($super_admin_role);

        // Teacher
        $permission_create->assignRole($teacher_role);
        $permission_read->assignRole($teacher_role);
        $permission_update->assignRole($teacher_role);
        $permission_delete->assignRole($teacher_role);

        // Student
        $permission_read->assignRole($student_role);


        // Super Admin Seed
        $super_admin_user = User::where('email', 'admin@admin.com')->first();

        $super_admin_user->assignRole($super_admin_role->name);
        $super_admin_user->givePermissionTo($permission_create->name);
        $super_admin_user->givePermissionTo($permission_read->name);
        $super_admin_user->givePermissionTo($permission_update->name);
        $super_admin_user->givePermissionTo($permission_delete->name);


        // Sample Teacher Seed
        $teacher_user = User::where('email', 'teacher@teacher.com')->first();

        $teacher_user->assignRole($teacher_role->name);
        $teacher_user->givePermissionTo($permission_create->name);
        $teacher_user->givePermissionTo($permission_read->name);
        $teacher_user->givePermissionTo($permission_update->name);

        // Sample Teacher 2 Seed
        $teacher_user2 = User::where('email', 'teacher2@teacher.com')->first();

        $teacher_user2->assignRole($teacher_role->name);
        $teacher_user2->givePermissionTo($permission_create->name);
        $teacher_user2->givePermissionTo($permission_read->name);
        $teacher_user2->givePermissionTo($permission_update->name);

        // Sample Teacher 3 Seed
        $teacher_user3 = User::where('email', 'teacher3@teacher.com')->first();

        $teacher_user3->assignRole($teacher_role->name);
        $teacher_user3->givePermissionTo($permission_create->name);
        $teacher_user3->givePermissionTo($permission_read->name);
        $teacher_user3->givePermissionTo($permission_update->name);

        // Sample Teacher 4 Seed
        $teacher_user4 = User::where('email', 'teacher4@teacher.com')->first();

        $teacher_user4->assignRole($teacher_role->name);
        $teacher_user4->givePermissionTo($permission_create->name);
        $teacher_user4->givePermissionTo($permission_read->name);
        $teacher_user4->givePermissionTo($permission_update->name);


        // Sample Student Seed
        $student_user = User::where('email', 'student@student.com')->first();

        $student_user->assignRole($student_role->name);
        $student_user->givePermissionTo($permission_read->name);

        // Sample Student 2 Seed
        $student_user2 = User::where('email', 'student2@student.com')->first();

        $student_user2->assignRole($student_role->name);
        $student_user2->givePermissionTo($permission_read->name);

        // Sample Student 3 Seed
        $student_user3 = User::where('email', 'student3@student.com')->first();

        $student_user3->assignRole($student_role->name);
        $student_user3->givePermissionTo($permission_read->name);

        // Sample Student 4 Seed
        $student_user4 = User::where('email', 'student4@student.com')->first();

        $student_user4->assignRole($student_role->name);
        $student_user4->givePermissionTo($permission_read->name);
    }
}
