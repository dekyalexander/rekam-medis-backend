<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;

class AuthRepository {

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

}