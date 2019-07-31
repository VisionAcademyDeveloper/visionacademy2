<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Course;
use App\Role;
use App\Policies\CoursePolicy;
use App\Chapter;
use App\Policies\ChapterPolicy;
use App\Policies\RolePolicy;

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
        Role::class => RolePolicy::class,


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
        Gate::define('add-chapter', 'App\Policies\ChapterPolicy@addChapter');

        //
    }
}
