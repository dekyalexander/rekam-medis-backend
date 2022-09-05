<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserUnit;
use Illuminate\Support\Facades\DB;

class UserRepository
{

  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  
  public function data($request)
  {
    if(isset($request['relations'])){

      $users =  $this->user::with($request['relations'])
      ->when(isset($request['role_id']), function ($query)  use ($request) {
        $query->WhereHas('roles', function ($q) use ($request) {
          return $q->where('role_id', '=', $request['role_id']);
        });
      })
      ->orderBy('name', 'ASC');

    }else{
      $users =  $this->user::orderBy('name', 'ASC');
    }

    return $users;
  
  }

  public function getUsersByFilters($filters)
  {
    return  
    User::with([
      'user_type',
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('username','like','%'.$filters['keyword'].'%')
            ->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }

  public function getAllUsers(){
    return $this->user;
  }

  public function getForOptions($filters)
  {    
    return User::select('id','name')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    })
    ->limit(10)->get();
  }

  // deoadd
  public function getUserByUsername($username)
  {
    return User::where('username',$username);
  }
  
  public function myUser($id)
  {
    return $this->user->find($id);
  }

  // public function getById($id,$selects=['*']){
  //   return User::select($selects)
  //   ->where('id','=',$id);
  // }

  public function getUserWithRoles($user_id){
    // return $this->user
    // ->with([
    //   'roles',
    //   'user_type:parameters.value,parameters.name,parameters.code',
    //   'employee:employees.id,employees.user_id,employees.name',
    //   'student:students.id,students.user_id,students.name',
    //   'parent:parents.id,parents.user_id,parents.name',
    //   'roles.unit.unit_type:parameters.value,parameters.name,parameters.code',
    //   'units',
    //   'units.occupations'=>function($query)use($user_id){$query->where('user_id',$user_id);}        
    //   ])
    // ->where('id',$user_id);
  
    return $this->user
    ->with([
      'roles',
      'user_type:parameters.value,parameters.name,parameters.code',
      'employee:employees.id,employees.user_id,employees.name',
      'student:students.id,students.user_id,students.name',
      'parent:parents.id,parents.user_id,parents.name',
      'roles.unit.unit_type:parameters.value,parameters.name,parameters.code',     
      ])
    ->where('id',$user_id);
  }

  public function getRoleOfNotUser($id){
    return $this->user->find($id);
  }

  public function getById($id)
  {
    return $this->user->find($id);
  }

  public function getUnitOfUser($request)
  {
    return $this->user->with(['children:id,name','parent:id,name','application:id,name', 'roles'])
            ->select('id', 'name', 'application_id')
            ->when(isset($request['application_id']), function ($query) use ($request) {
              return $query->orWhere('application_id', $request['application_id']);
            })
            ->when(isset($request['not_application_id']), function ($query) use ($request) {
              return $query->orWhere('application_id', '<>', $request['not_application_id']);
    });
  }

  public function store($data)
  {
    $result = User::create($data);
    return $result;
  }

  public function insertUser($data){
    return User::insert($data);
  }

  public function insertUserGetId($data){
    return User::insertGetId($data);
  }
  
  public function storeUserUnit($data)
  {
    $result = UserUnit::create($data);
    return $result;
  }

  public function edit($id)
  {
    $result = User::where('id', $id)->first();
    return $result;
  }

  public function update($column_id, $id, $data)
  {
    $result = User::where($column_id, $id)->update($data);
    return $result;
  }

  public function updateByUserName($username, $data)
  {
    User::where('username', $username)->update($data);
  }

  public function destroy($data)
  {
    $id = $data->id;
    $result = User::destroy($id);
    return $result;
  }
}