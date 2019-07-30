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
            ],
            [
                'acronym' => 'IS',
                'name' => 'Information Systems',
                'logo_url' => 'IS.png',
            ],
            [
                'acronym' => 'Math',
                'name' => 'Mathmatics',
                'logo_url' => 'Math.png',
            ]
        );
    }
}
