<?php

namespace App\Http\Controllers\API\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{

    public function  profile(Request $request)
    {

        $user = $request->user();
        return $user->profile;
    }

    public function  update(Request $request)
    {
        $user = $request->user();
        if (!Gate::allows('update-profile', $request->user()->profile)) {
            return Response::json([
                'success' => false,
                'message' => "You don't have the right permission to perform this action."
            ], 401);
        }


        $this->validateRequest();

        $user->profile->bio = $request->input('university_id');
        $user->profile->department_id = $request->input('department_id');
        $user->profile->bio = $request->input('bio');
        $user->name = $request->input('name');
        $user->push();
        $this->stroeAvatar($user->profile);

        return Response::json([
            'success' => true,
            'message' => 'Your profile has been updated successfully!',
            'profile' => $user->profile,
        ], 200);
    }



    private function stroeAvatar($profile)
    {
        if (request()->has('avatar')) {
            $profile->update(['avatar' => request()->logo_url->store('uploads/users_avatars', 'public')]);
        }
    }


    private function validateRequest()
    {
        return request()->validate([
            'university_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'name' => 'required|min:3:max:250',
            'avatar' => 'sometimes|file|image|max:500',
        ]);
    }
}
