<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $username = $request->input('username');
        $password1 = $request->input('password');
        $password2 = $request->input('confirm_password');
        $password = "";

        if ($password1 == $password2) {
            $password = Hash::make($password1);
        } else {
            return response()->json([
                'success' => "false",
                'mesasge' => 'password and confirm is not same',
                'code' => 204
            ]);
        }

        $user = User::create([
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);

        if ($user) {
            return response()->json([
                'success' => "true",
                'data' => $user,
                'mesasge' => 'success register user',
                'code' => http_response_code(200)
            ]);
        } else {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed register user',
                'code' => http_response_code(404)
            ]);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => "false",
                'mesasge' => 'Login failed',
                'code' => 401
            ]);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json([
                'success' => "false",
                'mesasge' => 'password incorrect',
                'code' => 401
            ]);
        }

        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);

        if ($user) {
            return response()->json([
                'success' => "true",
                'data' => $user,
                'mesasge' => 'login success',
                'code' => http_response_code(200)
            ]);
        } else {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'login failed',
                'code' => http_response_code(404)
            ]);
        }
    }

    public function priflMe(Request $request)
    {
        $token = $request->header('token');

        $user = User::where('token', $token)->first();


        if ($user) {
            return response()->json([
                'success' => "true",
                'data' => $user,
                'mesasge' => 'success get profil me',
                'code' => http_response_code(200)
            ]);
        } else {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed get profil me',
                'code' => http_response_code(404)
            ]);
        }
    }

    public function editProfil(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'user not found',
                'code' => 204
            ]);
        }

        $this->validate($request, [
            'email' => 'required|email',
            'username' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user->fill([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->new_password)
        ])->save();

        if ($user) {
            return response()->json([
                'success' => "true",
                'data' => $user,
                'mesasge' => 'success edit profil me',
                'code' => http_response_code(200)
            ]);
        } else {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed edit profil me',
                'code' => http_response_code(404)
            ]);
        }
    }
}
