<?php

namespace App\Http\Controllers\API\Department;

use App\Http\Controllers\Controller;
use App\Department;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function getAllDepartments()
    {
        $departments = Department::OrderBy('id', 'asc')->get();
        return Response::json($departments);
    }

    public static  function getDepartment(Request $request)
    {
        $request->validate([
            'department_id' => 'required|numeric',
        ]);
        $department = Department::find($request->department_id);
        if ($department == null)
            return Response::json([
                'status' => 'error',
                'message' => 'The required department not found!'
            ]);
        return Response::json($department);
    }
}
