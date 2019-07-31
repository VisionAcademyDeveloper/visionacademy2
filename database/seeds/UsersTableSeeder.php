<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_teacher = Role::where('name', 'Teacher')->first();
        $role_student = Role::where('name', 'Student')->first();
        $role_admin = Role::where('name', 'Admin')->first();

        $user = new User();
        $user->name = 'Naif Alshehri';
        $user->email = 'it676@hotmail.com';
        $user->password = bcrypt('naifnaif');
        $user->save();
        $user->roles()->attach($role_teacher);


        $user = new User();
        $user->name = 'Kayan Naif';
        $user->email = 'Kayan@hotmail.com';
        $user->password = bcrypt('kayankayan');
        $user->save();
        $user->roles()->attach($role_student);


        $user = new User();
        $user->name = 'Maram';
        $user->email = 'maram@hotmail.com';
        $user->password = bcrypt('marammaram');
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
