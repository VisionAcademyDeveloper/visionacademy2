<?php

namespace App\Policies;

use App\User;
use App\File;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Course;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine whether the user can add files.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $course_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            return false;
        }
        if ($course->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function update(User $user, File $file)
    {
        if ($user->id === $file->course->user_id) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can delete the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function delete(User $user, File $file)
    {
        if ($user->id == $file->course->user_id) {
            return true;
        }
        return false;
    }
}
