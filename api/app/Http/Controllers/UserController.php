<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Admin Classes Goes Here
    public function user()
    {
        $user = User::all();

        return response()->json([
            'user' => $user
        ], 200);
    }


    // User Classes Goes Here
    public function admin()
    {
        $user = User::all();

        return response()->json([$user], 200);
    }
}
