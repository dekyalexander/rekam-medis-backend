<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Laravel\Passport\Token;

class UserController extends Controller
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function getUserByToken(Request $request)
  {      
    $token = $request->bearerToken();
    $publicKey = file_get_contents(storage_path('oauth-public.key'));
    $res = JWT::decode($token, $publicKey, ['RS256']);
    
    $user = Token::findOrFail($res->jti)->user;
    if($user){
      return $this->userService->getUserWithAccess($user->id);
    }
    return response(['message' => 'Invalid Credentials']);    
  }

  public function data(Request $request)
  {
    $reqParams = $request->all();
    
    try {
      $query = $this->userService->data($reqParams);

      if (isset($request->page)) {
        $result = $query->paginate($request->rowsPerPage);
      } else {
        $result = $query->get();
      }

      return response($result);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getStudentsByFilters(Request $request)
  {
    $filters=[
      'keyword'=>$request->keyword
    ];
    
    return $this->userService->getByFiltersPagination($filters, $request->rowsPerPage);
  }

  public function getUnitOfUser(Request $request){

    $data = $request->user_id;

    try {
      $query = $this->userService->getUnitOfUser($data);
      return response($query);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
    
  }

  public function getRoleOfUser(Request $request){  
    try {

      if($request->not_user_id){
        $query = $this->userService->getRoleOfNotUser($request->not_user_id);
      }else{
        $query = $this->userService->getRoleOfUser($request->user_id);
      }

      return response($query);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
    
  }

  public function myUser(){

    $id = auth('api')->user()->id;

    try {
      $result = $this->userService->myUser($id);
      return response($result);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getForOptions(Request $request) {
    try {
      $filters=[
        'name'=>$request->name
      ];
      $query = $this->userService->getForOptions($filters);
      return response($query);
    } catch (\Exception $e) {
        return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
}

  public function store(Request $request)
  {

    $request->validate([
      'name' => 'required',
      'email' => 'required',
    ]);

    return $this->userService->store($request);

  }


  public function changePassword(Request $request)
  {
    
    return $this->userService->changePassword($request->user_id, $request->new_password);
  }

  public function resetPassword(Request $request)
  {
    
    return $this->userService->resetPassword($request->user_id);
  }

  public function storeOfEmployes(Request $request)
  {
    return $this->userService->storeOfEmployes($request);
  }

  public function updateOfEmployes(Request $request)
  {
    $data = [
      'name'=>$request->emp_name,
      'emp_status'=>$request->emp_status
    ];

    $result = $this->userService->update('emp_id', $request->emp_id, $data);

    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function addRole(Request $request)
  {

    $request->validate([
      'user_id' => 'required',
      'role_ids' => 'required',
    ]);

    return $this->userService->addRole($request->user_id, $request->role_ids);

  }

  public function addUserOfRole(Request $request){

    $request->validate([
        'role_id' => 'required',
        'user_ids' => 'required',
    ]);

    $result = $this->roleService->addUserOfRole($request);

    if($result){
        return response()->json(['message'=>'stored data'], $this->success);
    }else{
        return response()->json(['errors'=>['store'=>'stored failed']], $this->error);
    }

  }

  public function addUnit(Request $request){

    $request->validate([
        'user_id' => 'required',
        'unit_ids' => 'required',
    ]);

    $result = $this->userService->addUnit($request);

    if($result){
        return response()->json(['message'=>'stored data'], $this->success);
    }else{
        return response()->json(['errors'=>['store'=>'stored failed']], $this->error);
    }

}

  public function edit($id)
  {
    $result = $this->userService->edit($id);
    return $result;
  }

  public function update(Request $request)
  {

    $data = [
      'name'=>$request->name,
      'email'=>$request->email,
      'username'=>$request->username
    ];

    $result = $this->userService->update('id', $request->id, $data);

    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function destroy(Request $request)
  {
    $result = $this->userService->destroy($request);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }
  }

  public function deleteRoleOfUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_ids' => 'required',
        ]);

        $result = $this->userService->deleteRoleOfUser($request->user_id, $request->role_ids);

        if($result){
            return response()->json(['message'=>'delete data'], $this->success);
        }else{
            return response()->json(['errors'=>['delete'=>'delete failed']], $this->error);
        }
    }

}
