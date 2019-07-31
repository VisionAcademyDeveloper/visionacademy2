<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UniversitiesTableSeeder::class,
            DepartmentsTableSeeder::class,
            UsersTableSeeder::class,
            CoursesTableSeeder::class,
            RolesTableSeeder::class,


        ]);
    }
}
