<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
  public function login(Request $request)
  {
        //validate incoming request
    $this->validate($request, [
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = $request->only(['username', 'password']);

    if (!$token = Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    return response()->json([
      'user' => Auth::user(),
      'token' => $token,
      'token_type' => 'bearer',
      'expires_in' => Auth::factory()->getTTL() * 60
    ]);
  }

  public function register(Request $request)
  {
    //validate incoming request
    $this->validate($request, [
        'name' => 'required|string',
        'username' => 'required|unique:users',
        'password' => 'required|confirmed',
    ]);

    try {
      $user = new User();
      $user->name = $request->input('name');
      $user->username = $request->input('username');
      $plainPassword = $request->input('password');
      $user->password = app('hash')->make($plainPassword);
      $user->save();

      //return successful response
      return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

    } catch (\Exception $e) {

      //return error message
      return response()->json(['message' => 'User Registration Failed!'], 409);
    }
  }
}
