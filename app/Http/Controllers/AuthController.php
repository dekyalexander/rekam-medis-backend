<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $authService;

  public function __construct(AuthService $authService, UserService $userService)
  {
    $this->authService = $authService;
    $this->userService = $userService;
  }

  public function auth(Request $request)
  {
    $result = $this->authService->auth($request);

    if ($result['token']) {
      return response()->json(['message' => $result], $this->success);
    } else {
      return response()->json(['message' => 'Unauthenticated'], $this->error);
    }
  }

  public function access_token(Request $request)
  {
    $result = $this->authService->access_token($request);
    if ($result) {
      return response()->json(['access_token' => $result, 'token_type' => 'Bearer'], $this->success);
    } else {
      return response()->json(['errors' => ['auth' => 'Client Not Registered']], $this->unauth);
    }
  }

  public function login(Request $request)
  {

    $loginData = $request->validate([
      'username' => 'required',
      'password' => 'required'
    ]);


    $data = [
      'username' => $request->username,
      'password' => $request->password,
      'status_active' => 99
    ];

    return $this->authService->login($data);
  }
}