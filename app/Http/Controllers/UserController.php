<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

/**
 * Handles operations related to User
 */
class UserController extends Controller
{
    /**
     * Creates a new Token
     * 
     * It uses the users email and password from the request and 
     * checks in the user table for a match. If the user is validated then we 
     * will generate a token for the user to be used in subsequent API requests.
     * 
     * @param Illuminate\Http\Request $request
     */
    public function createToken(Request $request): JsonResponse
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
