<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Rules\ActivatedUser;
use App\Rules\ValidateUser;
use App\Rules\ValidatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logout successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Logout failed'], 500);
        }
    }

    public function login_success(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'required' => 'The :attribute field is required.',
                'email' => 'Invalid Email Id!',
            ]);
            if ($validator->fails()) {
                $message = $validator->errors()->first();
                return response()->json(['message' => $message]);
            }
            else if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['access_token' => $token, 'data' => 'login', 'token_type' => 'Bearer']);
            } else {
                return response()->json(['message' => 'Unauthorized user']);
            }
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage()]);
        }


    }

    public function register_user(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', new ValidateUser($request->email)],
                'password' => ['required'],
            ], [
                'required' => 'The :attribute field is required.',
                'email' => 'Invalid Email Id!',
                'email.unique' => 'User already exists.',
            ]);
            if ($validator->fails()) {
                $message = $validator->errors()->first();
                return response()->json(['message' => $message], 400);
            }

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json(['message' => 'User registered successfully'], 200);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['message' => 'An error occurred while registering the user'], 500);
        }

    }

    public function get_users()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }
}
