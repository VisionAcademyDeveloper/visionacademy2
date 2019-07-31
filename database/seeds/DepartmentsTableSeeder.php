<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert(
            [
                'acronym' => 'CS',
                'name' => 'Computer Science',
                'logo_url' => 'cs.png',
            ]
        );

        DB::table('departments')->insert(
            [
                'acronym' => 'IS',
                'name' => 'Computer Science',
                'logo_url' => 'is.png',
            ]
        );

        DB::table('departments')->insert(
            [
                'acronym' => 'Math',
                'name' => 'Mathmatics',
                'logo_url' => 'math.png',
            ]
        );
    }
}
