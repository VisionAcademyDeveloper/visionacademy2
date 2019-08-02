<?php

namespace App\Http\Controllers\API\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{

    public function getFilesByCourse($id)
    {
        $files = File::where('course_id', 1)->where('display', 1)->get();
        return Response::json([
            'success' => true,
            'message' => 'files returned successfully.',
            'total' => $files->count(),
            'files' => $files,
        ], 200);
    }

    public function getFile($id)
    {
        $file = File::where('id', $id)->where('display', 1)->first();
        if (!$file) {
            return Response::json([
                'success' => false,
                'message' => 'The required file not found!',
            ], 404);
        }
        return Response::json([
            'success' => true,
            'message' => 'file returned successfully.',
            'file' => $file,
        ], 200);
    }


    public function  add(Request $request)
    {
        $this->validateRequest();
        $course = Course::where('id', $request->course_id)->where('display', 1)->first();
        if (!$course) {
            return Response::json([
                'success' => false,
                'message' => 'The required course not found!',
            ], 404);
        }

        if (!Gate::allows('add-file', $request->course_id)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }

        $file = new File([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,

        ]);

        if ($file->save()) {
            $this->storeFile($file);
            return Response::json([
                'success' => true,
                'message' => 'New file has been added successfully!',
                'file' => $file,
            ], 201);
        }
    }



    public function update(Request $request, $id)
    {


        $file = File::where('id', $id)->where('display', 1)->first();

        $course = Course::where('id', $request->course_id)->where('display', $id)->first();

        if ($request->user()->id != $course->user_id) {

            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }


        if ($file) {

            if (!Gate::allows('update-file', $file)) {
                return Response::json([
                    'success' => false,
                    'message' => "You don't have the right permission to perform this action."
                ], 401);
            }
            $this->validateRequest();

            $file->course_id = $request->input('course_id');
            $file->title = $request->input('title');
            $file->description = $request->input('description');
            $file->update();

            $this->storeFile($file);

            return Response::json([
                'success' => true,
                'message' => 'Your file has been updated successfully!',
                'file' => $file,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'The required file not found!',
        ], 404);
    }

    public function delete($id)
    {
        $file = File::where('id', $id)->where('display', 1)->first();

        if ($file) {

            if (!Gate::allows('delete-file', $file)) {
                return Response::json([
                    'success' => false,
                    'message' => "You don't have the right permission to perform this action."
                ], 401);
            }

            $file->display = 0;
            $file->save();

            return Response::json([
                'success' => true,
                'message' => 'Your file has been deleted successfully!',
                'file' => $file,
            ], 200);
        }
        return Response::json([
            'success' => false,
            'message' => 'The required file not found!',
        ], 404);
    }

    private function validateRequest()
    {
        return request()->validate([
            'course_id' => 'required|numeric',
            'file_url' => 'sometimes|file|mimes:pdf,jpeg,bmp,png,doc,docx,csv,xlsx,zip,rar|max:20000',
            'title' => 'required',
            'description' => 'sometimes'
        ]);
    }

    private function storeFile($file)
    {
        if (request()->has('file_url')) {
            $file->update(['file_url' => request()->file_url->store('uploads/courses_files', 'public')]);
        }
    }
}
