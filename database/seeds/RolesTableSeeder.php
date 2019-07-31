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

        DB::table('roles')->insert(
            [
                'name' => 'student',
                'description' => 'Student who can Register for courses',
            ]
        );

        DB::table('roles')->insert(
            [
                'name' => 'teacher',
                'description' => 'Teacher who can manage his courses and students',
            ]
        );

        DB::table('roles')->insert(
            [
                'name' => 'author',
                'description' => 'Author who can manage posts',
            ]
        );

        DB::table('roles')->insert(
            [
                'name' => 'admin',
                'description' => 'Admin who can mange the entire app',
            ]
        );
    }
}
