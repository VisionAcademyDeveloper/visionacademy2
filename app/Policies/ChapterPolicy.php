<?php

namespace App\Policies;

use App\User;
use App\Chapter;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Course;

class ChapterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any chapters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the chapter.
     *
     * @param  \App\User  $user
     * @param  \App\Chapter  $chapter
     * @return mixed
     */
    public function view(User $user, Chapter $chapter)
    {
        //
    }

    /**
     * Determine whether the user can create chapters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function addChapter(User $user, $course_id)
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
     * Determine whether the user can update the chapter.
     *
     * @param  \App\User  $user
     * @param  \App\Chapter  $chapter
     * @return mixed
     */
    public function update(User $user, Chapter $chapter)
    {
        //
    }

    /**
     * Determine whether the user can delete the chapter.
     *
     * @param  \App\User  $user
     * @param  \App\Chapter  $chapter
     * @return mixed
     */
    public function delete(User $user, Chapter $chapter)
    {
        //
    }

    /**
     * Determine whether the user can restore the chapter.
     *
     * @param  \App\User  $user
     * @param  \App\Chapter  $chapter
     * @return mixed
     */
    public function restore(User $user, Chapter $chapter)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the chapter.
     *
     * @param  \App\User  $user
     * @param  \App\Chapter  $chapter
     * @return mixed
     */
    public function forceDelete(User $user, Chapter $chapter)
    {
        //
    }
}
