<?php

use Illuminate\Database\Seeder;
use App\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $course = new Course();
        $course->name = 'Java Programming';
        $course->user_id = 1;
        $course->old_price = 800;
        $course->price = 500;
        $course->description = 'In this course we will learn Java Programming in depth.';
        $course->save();


        $course = new Course();
        $course->name = 'Operating Systems';
        $course->user_id = 1;
        $course->old_price = 1200;
        $course->price = 600;
        $course->description = 'In this course we will learn about operating systems';
        $course->save();


        $course = new Course();
        $course->name = 'Data bases';
        $course->user_id = 1;
        $course->old_price = 600;
        $course->price = 300;
        $course->description = 'In this course we learn about databases.';
        $course->save();
    }
}
