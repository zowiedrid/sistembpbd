<?php

// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules\Password;

// class UserAuthController extends Controller
// {
//     public function register(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'name' => 'required',
//             'email' => 'required|unique:users',

//             'password' => ['required', Password::min(8)],
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->messages()->first()], 403);
//         }

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => bcrypt($request->password),
//         ]);

//         $user->save();

//         $token = $user->createToken('LaravelAPI')->accessToken;

//         return response()->json(['token' => $token,'user' => $user], 200);
//     }

//     public function login(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'email' => 'required|email',
//             'password' => 'required|min:6'
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->messages()->first()], 403);
//         }

//         $data = [
//             'email' => $request->email,
//             'password' => $request->password
//         ];


//         if (auth()->attempt($data)) {
//             $token = auth()->user()->createToken('LaravelAPI')->accessToken;

//             return response()->json(['token' => $token, 'user' => auth()->user()], 200);
//         }

//         return response()->json(['errors' => "Login Invalid"], 403);
//     }
// }
