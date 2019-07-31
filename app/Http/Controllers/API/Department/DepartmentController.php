<?php

namespace App\Http\Controllers\API\Department;

use App\Http\Controllers\Controller;
use App\Department;
use Illuminate\Support\Facades\Response;

class DepartmentController extends Controller
{
    public function getAllDepartments()
    {

        $departments = Department::OrderBy('id', 'asc')->get();
        return Response::json([
            'success' => true,
            'message' => 'All departments returned successfully.',
            'departments' => $departments
        ], 200);
    }

    public static  function getDepartment($id)
    {
        $id = (int) $id;

        $department = Department::find($id);
        if ($department == null)
            return Response::json([
                'success' => false,
                'message' => 'The required department not found!'
            ], 404);
        return  Response::json([
            'success' => true,
            'message' => 'The required university returned successfully!',
            'department' => $department
        ], 200);
    }
}
