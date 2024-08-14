<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function login(UserLoginRequest $request): JsonResponse
  {
    $request->validated();

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
      return response()->json([
        'errors' => ['email' => [trans('auth.failed')]],
        'messages' => trans('auth.failed'),
      ], 401);
    }

    return response()->json([
      'user' => Auth::user()
    ]);
  }

  public function register(UserRegisterRequest $request): JsonResponse
  {
    $request->validated();

    try {
      User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);
      return response()->json(null, 200);
    } catch (\Exception $e) {
      return response()->json([
        'messages' => $e->getMessage(),
      ], 400);
    }
  }

  public function update(UserUpdateRequest $request): JsonResponse
  {
    $request->validated();

    try {
      User::where('id', Auth::id())
        ->update([
          'name' => $request->name,
          'password' => Hash::make($request->password),
        ]);
      return response()->json(null, 200);
    } catch (\Exception $e) {
      return response()->json([
        'messages' => $e->getMessage(),
      ], 400);
    }
  }

  public function logout(): RedirectResponse
  {
    Auth::guard('web')->logout();

    return redirect('/');
  }
}
