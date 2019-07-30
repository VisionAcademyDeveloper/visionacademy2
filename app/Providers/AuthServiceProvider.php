<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Course;
use App\Policies\CoursePolicy;
use App\Chapter;
use App\Policies\ChapterPolicy;

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

        Gate::define('teacher-only', 'App\Policies\RolePolicy@isTeacher');
        Gate::define('create-course', 'App\Policies\CoursePolicy@create');
        Gate::define('add-chapter', 'App\Policies\ChapterPolicy@addChapter');

        //
    }
}
