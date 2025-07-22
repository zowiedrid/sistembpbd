<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    // Generate token for the user
    $tokenResult = $user->createToken('auth_token');
    // For Laravel Passport, use the token directly from the tokenResult
    $token = $tokenResult->accessToken;

    return response()->json([
        'data' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}

    public function login(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = User::where('email', $request['email'])->firstOrFail();
    $tokenResult = $user->createToken('auth_token');
    $token = method_exists($tokenResult, 'plainTextToken') ? $tokenResult->plainTextToken : $tokenResult->accessToken;

    return response()->json([
        'success' => true,
        'message' => 'Hi ' . $user->name . ', welcome to the system',
        'data' => [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]
    ]);
}

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ]);
    }
}
