<?php

namespace App\Http\Controllers\API\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{

    public function create(Request $request)
    {

        //Fixing N + 1 Problem
        // $request->user()->courses()->create([]);
        $this->validateRequest();

        // $image = Image::make(public_path('storage/' . $logo))->fit(400, 400);
        // $image->save();
        //Job for resizing image


        if ($request->user()->courses()->create([
            'university_id' => $request->input('university_id'),
            'department_id' => $request->input('department_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'old_price' => $request->input('old_price'),
            'description' => $request->input('description'),
            'preview_url' => $request->input('preview_url'),
            'prerequisites' => $request->input('prerequisites'),
            'classLink' => $request->input('classLink'),
            'classTableInfo' => $request->input('classTableInfo'),
        ])) {
            $course = $request->user()->courses()->latest()->first();
            $this->storeLogo($course); //should be a job in bg
            return Response::json([
                'success' => true,
                'message' => 'Your course has been created successfully!',
                'course' => $course,
            ], 201);
        }
    }


    public function getAllCourses()
    {
        $courses = Course::where('display', 1)->get();
        return Response::json([
            'success' => true,
            'message' => 'courses returned successfully.',
            'total' => $courses->count(),
            'courses' => $courses,
        ], 200);
    }

    public function getCoursesByDepartment($id)
    {
        $courses = Course::where('display', 1)->where('department_id', $id)->get();
        return Response::json([
            'success' => true,
            'message' => 'courses returned successfully.',
            'total' => $courses->count(),
            'courses' => $courses,

        ], 200);
    }


    public function getCoursesByTeacher($id)
    {
        $courses = Course::where('display', 1)->where('user_id', $id)->get();
        return Response::json([
            'success' => true,
            'message' => 'courses returned successfully.',
            'total' => $courses->count(),
            'courses' => $courses,

        ], 200);
    }

    public function getCoursesByLoggedTeacher()
    {
        return  auth('api')->user();


        $courses = Course::where('display', 1)->where('user_id', $user->id)->get();
        return Response::json([
            'success' => true,
            'message' => 'courses returned successfully.',
            'total' => $courses->count(),
            'courses' => $courses,

        ], 200);
    }

    public function getCourse($id)
    {
        $course = Course::where('id', $id)->where('display', 1)->first();
        if ($course) {
            return Response::json([
                'success' => true,
                'message' => 'course returned successfully.',
                'course' => $course,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'course not found',
        ], 404);
    }


    public function update(Request $request, $id)
    {
        //re-write it in modern way
        $course = Course::where('id', $id)->where('display', 1)->first();

        if ($course) {

            if (!Gate::allows('update-course', $course)) {
                return Response::json([
                    'success' => false,
                    'message' => "You don't have the right permission to perform this action."
                ], 401);
            }
            $this->validateRequest();

            $course->university_id = $request->input('university_id');
            $course->department_id = $request->input('department_id');
            $course->name = $request->input('name');
            $course->price = $request->input('price');
            $course->old_price = $request->input('old_price');
            $course->description = $request->input('description');
            $course->preview_url = $request->input('preview_url');
            $course->prerequisites = $request->input('prerequisites');
            $course->classLink = $request->input('classLink');
            $course->classTableInfo = $request->input('classTableInfo');
            $course->update();

            $this->storeLogo($course);

            return Response::json([
                'success' => true,
                'message' => 'Your course has been updated successfully!',
                'course' => $course,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'The required course not found!',
        ], 404);
    }

    public function delete($id)
    {
        $course = Course::where('id', $id)->where('display', 1)->first();

        if ($course) {

            if (!Gate::allows('delete-course', $course)) {
                return Response::json([
                    'success' => false,
                    'message' => "You don't have the right permission to perform this action."
                ], 401);
            }

            $course->display = 0; //the teacher can't delete the course permanently but hide it.
            $course->save();

            return Response::json([
                'success' => true,
                'message' => 'Your course has been deleted successfully!',
                'course' => $course,
            ], 200);
        }
        return Response::json([
            'success' => false,
            'message' => 'The required course not found!',
        ], 404);
    }
    private function storeLogo($course)
    {
        if (request()->has('logo_url')) {
            $course->update(['logo_url' => request()->logo_url->store('uploads/courses_logos', 'public')]);
        }
    }


    private function validateRequest()
    {
        return request()->validate([
            'university_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'name' => 'required|min:3:max:250',
            'old_price' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required',
            'logo_url' => 'sometimes|file|image|max:1000',
        ]);
    }
}
