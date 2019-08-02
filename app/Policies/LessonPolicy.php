<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Chapter;
use App\Lesson;

class LessonPolicy
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
     * Determine whether the user can create lessons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $chapter_id)
    {
        $chapter = Chapter::find($chapter_id);

        if ($user->id === $chapter->course->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the lesson.
     *
     * @param  \App\User  $user
     * @param  \App\Lesson  $lesson
     * @return mixed
     */
    public function update(User $user, Lesson $lesson)
    {
        $chapter = Chapter::find($lesson->chapter_id);
        if (!$chapter) {
            return false;
        }
        if ($user->id === $chapter->course->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the lesson.
     *
     * @param  \App\User  $user
     * @param  \App\Lesson  $chapter
     * @return mixed
     */
    public function delete(User $user, Lesson $lesson)
    {
        $chapter = Chapter::find($lesson->chapter_id);
        if (!$chapter) {
            return false;
        }
        if ($user->id === $chapter->course->user_id) {
            return true;
        }
        return false;
    }
}
