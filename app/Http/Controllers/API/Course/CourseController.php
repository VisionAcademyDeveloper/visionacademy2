<?php

namespace App\Http\Controllers\API\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class CourseController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'university_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'name' => 'required|min:3:max:250',
            'price' => 'required|numeric',
            'description' => 'required',
            'logo_url' => 'required|file|image|max:1000',
        ]);

        $logo = 'https://vsionacademy.online/logo.png';
        if ($request->hasFile('logo_url')) {
            $logo = $request->file('logo_url')->store('uploads/courses_logos', 'public');
            $image = Image::make(public_path('storage/' . $logo))->fit(400, 400);
            $image->save();
        }

        $course = new Course([
            'university_id' => $request->input('university_id'),
            'department_id' => $request->input('department_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'old_price' => $request->input('old_price'),
            'description' => $request->input('description'),
            'logo_url' => $logo,
            'preview_url' => $request->input('preview_url'),
            'prerequisites' => $request->input('prerequisites'),
            'classLink' => $request->input('classLink'),
            'classTableInfo' => $request->input('classTableInfo'),
        ]);

        if ($request->user()->courses()->save($course)) {

            return Response::json([
                'success' => true,
                'message' => 'Your course has been created successfully!',
                'course' => $course,
            ], 201);
        }
    }
}
