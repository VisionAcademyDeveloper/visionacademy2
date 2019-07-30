<?php

namespace App\Http\Controllers\API\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chapter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class ChapterController extends Controller
{

    public function  addChapter(Request $request)
    {
        if (!Gate::allows('teacher-only')) {
            return Response::json([
                'status' => 'error',
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }

        if (!Gate::allows('add-chapter', $request->course_id)) {
            return Response::json([
                'status' => 'error',
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }

        $request->validate([
            'title' => 'required',
            'course_id' => 'required|numeric'
        ]);

        $chapter = new Chapter([
            'title' => $request->title,
            'course_id' => $request->course_id
        ]);

        $chapter->save();

        return Response::json(['status' => 'success', 'message' => 'new chapter has been added successfully'], 200);
    }
}
