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
        }else{
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

        if($user){
            return response()->json([
                'success' => "true",
                'data' => $user,
                'mesasge' => 'success register user',
                'code' => http_response_code(200)
            ]);
        }else{
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed register user',
                'code' => http_response_code(404)
            ]);
        }


    }
}
