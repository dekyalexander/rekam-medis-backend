<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use App\Repositories\UserRepository;
use App\Services\UserService;
use \stdClass;

class AuthService
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $userRepo;
  protected $userService;

  public function __construct(UserRepository $userRepo, UserService $userService)
  {
    $this->userRepo = $userRepo;
    $this->userService = $userService;
  }

  public function auth($request)
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $user = Auth::user();
      $result['token'] = $user->createToken('Pahoa-Digital')->accessToken;
      return $result;
    } else {
      $result['token'] = '';
      return $result;
    }
  }

  public function login($data)
  {

    if (!auth()->attempt($data)) {
      return response(['message' => 'Invalid Credentials']);
    }

    $user_id = auth()->user()->id;
    $accessToken = auth()->user()->createToken('authToken')->accessToken;

    $userWithAccess = $this->userService->getUserWithAccess($user_id);
    // $userWithAccess->access_token = $accessToken;

    $userWithAccess = $this->userService->getUserWithAccess($user_id);
    // $userWithAccess->access_token = $accessToken;

    $userWithAccess['access_token']  = $accessToken;
    return response($userWithAccess);

    // return $userWithAccess;        
  }
}