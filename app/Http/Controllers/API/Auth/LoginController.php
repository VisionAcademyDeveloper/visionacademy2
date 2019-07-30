<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use GuzzleHttp;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return Response::json([
                'status' => 'error',
                'message' => 'Invalid credentials, please try again.'
            ], 401);
        }

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

        return Response::json([
            'status' => 'success',
            'message' => 'You have logged in successfully!',
            'data' => json_decode((string) $response->getBody(), true)
        ], 200);
    }
}
