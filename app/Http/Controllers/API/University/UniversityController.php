<?php

namespace App\Http\Controllers\API\University;

use App\Http\Controllers\Controller;
use App\University;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class UniversityController extends Controller
{

    public function getAllUniversities()
    {

        $universities = University::OrderBy('id', 'asc')->get();
        return Response::json([
            'success' => true,
            'message' => 'All unversrties returned successfully.',
            'universties' => $universities
        ], 200);
    }

    public static  function getUniversity($id)
    {
        $id = (int) $id;

        $university = University::find($id);
        if ($university == null)
            return Response::json([
                'success' => false,
                'message' => 'The required university not found!'
            ],404);
        return  Response::json([
            'success' => true,
            'message' => 'The required university returned successfully!',
            'university' => $university
        ], 200);
    }
}
