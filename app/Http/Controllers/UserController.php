<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createToken(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken($data['email'])->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ]);
    }
}
