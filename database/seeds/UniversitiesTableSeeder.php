<?php

use Illuminate\Database\Seeder;

class UniversitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('universities')->insert(
            [
                'acronym' => 'KSU',
                'name' => 'King Saud University',
                'logo_url' => 'http://www.samayaholding.com/systemimages/partners/75.jpg',
            ],
            [
                'acronym' => 'PNU',
                'name' => 'Princess Nora University',
                'logo_url' => 'https://najlaaljohar.files.wordpress.com/2014/09/logo.png',
            ],
            [
                'acronym' => 'PNU',
                'name' => 'Imam University',
                'logo_url' => 'https://maahid.imamu.edu.sa/EduWave/Images/ImamImages/Imam_Logo.gif',
            ]
        );
    }
}
