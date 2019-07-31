<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_student = new Role();
        $role_student->name = 'student';
        $role_student->description = 'Student who can Register for courses';
        $role_student->save();



        $role_teacher = new Role();
        $role_teacher->name = 'teacher';
        $role_teacher->description = 'Teacher who can manage his courses and students';
        $role_teacher->save();


        $role_author = new Role();
        $role_author->name = 'author';
        $role_author->description = 'Author who can manage posts';
        $role_author->save();

        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'Admin who can mange the entire app';
        $role_admin->save();
    }
}
