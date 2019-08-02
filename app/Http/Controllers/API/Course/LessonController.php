<?php

namespace App\Http\Controllers\API\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Chapter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class LessonController extends Controller
{


    public function getLessonsByChapter($id)
    {

        $lessons = Lesson::where('display', 1)->where('chapter_id', $id)->get();
        return Response::json([
            'success' => true,
            'message' => 'all lessons returned successfully.',
            'total' => $lessons->count(),
            'lessons' => $lessons,
        ], 200);
    }

    public function getLesson($id)
    {
        $lesson = Lesson::where('id', $id)->where('display', 1)->first();
        if ($lesson) {
            return Response::json([
                'success' => true,
                'message' => 'lesson returned successfully.',
                'lesson' => $lesson,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'The required lesson not found!',
        ], 404);
    }



    public function  create(Request $request)
    {
        $this->validateRequest();
        $chapter = Chapter::where('id', $request->chapter_id)->where('display', 1)->first();
        if (!$chapter) {
            return Response::json([
                'success' => false,
                'message' => 'The required chapter not found!',
            ], 404);
        }

        if (!Gate::allows('add-lesson', $request->chapter_id)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }


        $lesson = new Lesson([
            'chapter_id' => $request->chapter_id,
            'video_id' => $request->video_id,
            'open' => $request->open,
            'title' => $request->title,
            'teacher_notes' => $request->teacher_notes,

        ]);

        if ($lesson->save()) {
            return Response::json([
                'success' => true,
                'message' => 'New lesson has been added successfully!',
                'lesson' => $lesson,
            ], 201);
        }
    }



    public function update(Request $request, $id)
    {
        $lesson = Lesson::where('id', $id)->where('display', 1)->first();

        if (!$lesson) {
            return Response::json([
                'success' => false,
                'message' => 'The required lesson not found!',
            ], 404);
        }

        if (!Gate::allows('update-lesson', $lesson)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }
        $this->validateRequest();
        $lesson->chapter_id = $request->input('chapter_id');
        $lesson->video_id = $request->input('video_id');
        $lesson->open = $request->input('open');
        $lesson->title = $request->input('title');
        $lesson->teacher_notes = $request->input('teacher_notes');
        $lesson->update();

        return Response::json([
            'success' => true,
            'message' => 'Your lesson has been updated successfully!',
            'lesson' => $lesson,
        ], 200);
    }


    public function delete($id)
    {
        $lesson = Lesson::where('id', $id)->where('display', 1)->first();

        if (!$lesson) {
            return Response::json([
                'success' => false,
                'message' => 'The required chapter not found!',
            ], 404);
        }

        if (!Gate::allows('delete-lesson', $lesson)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }

        $lesson->display = 0; //the teacher can't delete the lesson permanently but hide it.
        $lesson->update();

        return Response::json([
            'success' => true,
            'message' => 'Your lesson has been deleted successfully!',
            'lesson' => $lesson,
        ], 200);
    }
    private function validateRequest()
    {
        return request()->validate([
            'chapter_id' => 'required|numeric',
            'video_id' => 'required|numeric',
            'open' => 'required|numeric',
            'title' => 'required',
            'teacher_notes' => 'sometimes'
        ]);
    }
}
