<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Profile;
use GuzzleHttp;
use App\Events\NewUserHasRegisteredEvent;
use App\Role;

class RegisterController extends Controller
{


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'university_id' => 'required|numeric',
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        if ($user->save()) {

            $client = new GuzzleHttp\Client;
            $response = $client->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => env('API_GRANT_TYPE'),
                    'client_id' => env('API_CLIENT_ID'),
                    'client_secret' => env('API_CLIENT_SECRET'),
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);

            $role_teacher = Role::where('name', 'Teacher')->first();
            // event(new NewUserHasRegisteredEvent($user));
            $user->roles()->attach($role_teacher);

            return Response::json([
                'success' => true,
                'message' => 'Your account has been created successfully!',
                'user' => $user,
                'token_data' => json_decode((string) $response->getBody(), true)
            ], 201);
        } else {
            return Response::json([
                'success' => false,
                'message' => 'Whoops this is embarrassing error , try again please.',
                'user' => null,
                'token_data' => null
            ], 500);
        }
    }
}
