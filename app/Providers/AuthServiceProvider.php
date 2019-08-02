<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Course;
use App\Policies\CoursePolicy;
use App\Chapter;
use App\Policies\ChapterPolicy;
use App\Policies\LessonPolicy;
use App\File;
use App\Policies\FilePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Course::class => CoursePolicy::class,
        Chapter::class => ChapterPolicy::class,
        Lesson::class => LessonPolicy::class,
        File::class => FilePolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Gate::define('update-course', 'App\Policies\CoursePolicy@update');
        Gate::define('delete-course', 'App\Policies\CoursePolicy@delete');

        Gate::define('add-chapter', 'App\Policies\ChapterPolicy@create');
        Gate::define('update-chapter', 'App\Policies\ChapterPolicy@update');
        Gate::define('delete-chapter', 'App\Policies\ChapterPolicy@delete');

        Gate::define('add-lesson', 'App\Policies\LessonPolicy@create');
        Gate::define('update-lesson', 'App\Policies\LessonPolicy@update');
        Gate::define('delete-lesson', 'App\Policies\LessonPolicy@delete');

        Gate::define('add-file', 'App\Policies\FilePolicy@create');
        Gate::define('update-file', 'App\Policies\FilePolicy@update');
        Gate::define('delete-file', 'App\Policies\FilePolicy@delete');
    }
}
