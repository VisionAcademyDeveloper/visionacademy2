<?php

namespace App\Http\Controllers\API\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chapter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use App\Course;

class ChapterController extends Controller
{


    public function getAllChapters($id)
    {

        $chapters = Chapter::where('display', 1)->where('course_id', $id)->get();
        return Response::json([
            'success' => true,
            'message' => 'all chapters returned successfully.',
            'total' => $chapters->count(),
            'chapters' => $chapters,
        ], 200);
    }

    public function getChapter($id)
    {
        $chapter = Chapter::where('id', $id)->where('display', 1)->first();
        if ($chapter) {
            return Response::json([
                'success' => true,
                'message' => 'chapter returned successfully.',
                'chapter' => $chapter,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'The required chapter not found!',
        ], 404);
    }

    public function  create(Request $request)
    {


        if (!Gate::allows('add-chapter', $request->course_id)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }

        $this->validateRequest();

        $chapter = new Chapter([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id
        ]);

        $chapter->save();
        return Response::json([
            'success' => true,
            'message' => 'New chapter has been added successfully!',
            'chapter' => $chapter,
        ], 201);
    }


    public function update(Request $request, $id)
    {

        $chapter = Chapter::where('id', $id)->where('display', 1)->first();

        if (!$chapter) {

            return Response::json([
                'success' => false,
                'message' => 'The required chapter not found!',
            ], 404);
        }
        if (!Gate::allows('update-chapter', $chapter)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }
        $this->validateRequest();

        $chapter->title = $request->input('title');
        if ($request->has('description'))
            $chapter->description = $request->input('description');
        $chapter->update();

        return Response::json([
            'success' => true,
            'message' => 'Your chapter has been updated successfully!',
            'course' => $chapter,
        ], 200);
    }


    public function delete($id)
    {
        $chapter = Chapter::where('id', $id)->where('display', 1)->first();

        if (!$chapter) {

            return Response::json([
                'success' => false,
                'message' => 'The required chapter not found!',
            ], 404);
        }

        if (!Gate::allows('delete-chapter', $chapter)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }



        $chapter->display = 0; //the teacher can't delete the chapter permanently but hide it.
        $chapter->save();

        return Response::json([
            'success' => true,
            'message' => 'Your chapter has been deleted successfully!',
            'chapter' => $chapter,
        ], 200);
    }



    private function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'course_id' => 'required|numeric'
        ]);
    }
}
