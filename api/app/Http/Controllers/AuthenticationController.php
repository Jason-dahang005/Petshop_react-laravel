<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'firstname'             => 'required|string|max:255',
            'lastname'              => 'required|string|max:255',
            'email'                 => 'required|email:rfc,dns|unique:users,email',
            'address'               => 'required|string|max:255',
            'phone'                 => 'required|string|min:11',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'firstname.required'    => 'First name is required',
            'lastname.required'     => 'Last name is required',
            'email.unique'          => 'Email is already taken',
            'phone.min'             => 'Phone number should be atleast 11 numbers',
            'password.min'          => 'Password should be atleast 8 characters'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors(),
            ], 422);
        }

        $data = $r->all();

        $data['firstname']  = ucwords($data['firstname']);
        $data['lastname']   = ucwords($data['lastname']);
        $data['password']   = bcrypt($data['password']);
        $user = User::create($data);

        if(User::count() == 1){
            $user->assignRole('admin');
        } else {
            $user->assignRole('user');
        }

        return response()->json([
            'status'        => 'success',
            'credentials'   => $user,
            'message'       => 'Registered Successful!'
        ], 201);

    }

    public function login(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'email'                 => 'required|email:rfc,dns|exists:users',
            'password'              => 'required|min:8',
        ], [
            'email.required'        => 'Email field is required',
            'email.exists'          => 'Email does not exist',
            'password.required'     => 'Password field is required',
            'password'              => 'Password does not match',
            'password.min'          => 'Password should be at least 8 characters'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors(),
            ], 422);
        }

        $credentials = $r->only('email', 'password');

        if(Auth::guard('web')->attempt($credentials)){
            $user = User::query()->where('email', $r['email'])->first();
            $user->roles;
            $token = $user->createToken('ACCESS_TOKEN')->accessToken;

            return response()->json([
                'message'   => 'login successfully',
                'user'      => $user,
                'token'     => $token
            ], 200);
        } else {
            return response()->json([
                'message'        => 'Invalid credentials',
            ], 401);
        }
    }
}
