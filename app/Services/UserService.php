<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\MenuRepository;
use App\Repositories\ActionRepository;
use App\Repositories\UnitRepository;
use App\Repositories\EmployeeCareerRepository;
use App\Models\User;
use App\Repositories\EmployeeHRISRepository;

class UserService {

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $userRepo;
  protected $roleRepo;
  protected $applicationRepository;
  protected $menuRepository;
  protected $actionRepository;
  protected $unitRepository;
  protected $employeeCareerRepository;
  protected $employeeHris;

  public function __construct(
    UserRepository $userRepo, 
    RoleRepository $roleRepo, 
    ApplicationRepository $applicationRepository,
    MenuRepository $menuRepository,
    ActionRepository $actionRepository,
    UnitRepository $unitRepository,
    EmployeeCareerRepository  $employeeCareerRepository,
    EmployeeHRISRepository $employeeHris,
    ){
    $this->userRepo = $userRepo;
    $this->roleRepo = $roleRepo;
    $this->applicationRepository = $applicationRepository;
    $this->menuRepository = $menuRepository;
    $this->actionRepository = $actionRepository;
    $this->unitRepository = $unitRepository;
    $this->employeeCareerRepository = $employeeCareerRepository;
    $this->employeeHris = $employeeHris;
  }

  public function data($request)
  {
    $result = $this->userRepo->data($request);
    return $result;
  }

  public function getByFiltersPagination($filters, $rowsPerPage=25){
    return $this->userRepo
    ->getUsersByFilters($filters)      
    ->paginate($rowsPerPage);
  }

  public function getUnitOfUser($user_id)
  {
    $user = $this->userRepo->getById($user_id);
    return $user->units()->get();
    // return $user->with('units')->get();
  }

  public function getRoleOfUser($user_id)
  {
    $user = $this->userRepo->getById($user_id);
    return $user->roles()->get();
  }

  public function getRoleOfNotUser($user_id)
  {
    $role = $this->roleRepo->getRoleNotId($user_id);
    return $role->get();
  }

  public function deleteRoleOfUser($user_id, $role_ids){
    $user = $this->userRepo->getById($user_id);
    return $user->roles()->detach($role_ids);
  }

  public function getUserWithAccess($user_id){
    
    $userAccess = $this->userRepo->getUserWithRoles($user_id)->first(); 
      
      $user = [
        'id'=>$userAccess->id,
        'name'=>$userAccess->name,
        'username'=>$userAccess->username,
        'email'=>$userAccess->email,
        'user_type'=>$userAccess->user_type,
        'isActive'=>$userAccess->isActive,
        'employee'=>$userAccess->employee,
        'student'=>$userAccess->student,
        'parent'=>$userAccess->parent,
      ];
      
      //'units' => $userAccess->roles,

      $units    = [];
      // $jabatans = [];
      $roles    = [];
      $role_ids = [];

      foreach ($userAccess->roles as $role) {
        array_push(
          $roles,
          [
            'id'=>$role->id,
            'name'=>$role->name,
            'code'=>$role->code,
            'description'=>$role->description,
            'data_access_value'=>$role->data_access_value,
            'head_role_id'=>$role->head_role_id
          ]            
        );

        array_push($role_ids,$role->id);

      }


      // foreach ($userAccess->units as $item){
      //   array_push($units,[
      //     'unit_id' => $item->id,
      //     'unit_name' => $item->name,
      //     'unit_type_value' => $item->unit_type->value,
      //     'jabatan_id' => $item->occupations[0]->id,
      //     'jabatan_name' => $item->occupations[0]->occupation_name,
      //     'jabatan_unit_value' => $item->occupations[0]->unit_type_value,
      //     'jabatan_unit_name' => $item->occupations[0]->name_type_unit,
      //   ]);
      // }
      $userNik = $this->userRepo->getById($user_id);
      $employee_id = $this->employeeHris->getUserIdByUsername($userNik->username);
      $careers = $this->employeeCareerRepository->getEmployeeCareers($employee_id);

      if($careers){
        foreach($careers as $item){
          array_push($units,[
            'position_id'        =>  $item->employee_position_id,
            'position_name'      =>  $item->employeeposition->name,
            'position_code'      =>  $item->employeeposition->code,
            'position_parent'    =>  $item->employeeposition->parent,
            'unit_id'            =>  $item->employeeposition->employeeunit->id,
            'unit_name'          =>  $item->employeeposition->employeeunit->name,
            'unit_type_id'       =>  $item->employeeposition->employeeunit->employee_unit_type_id,
            'unit_type_value'    =>  $item->employeeposition->employeeunit->employeeunitypes->name,
            // 'jabatan_id'         =>  $item->employee_occupation_id,
            // 'jabatan_name'       =>  $item->occupation->name,
            // 'jabatan_unit_value' =>  $item->occupation->employee_unit_type_id,
            // 'jabatan_unit_name'  =>  $item->occupation->employeeunitypeoccupation->name,
          ]);
        }
      }


      $applications = $this->applicationRepository->getApplicationsOfRoles($role_ids);
      $menus = $this->menuRepository->getMenusOfRoles($role_ids);
      $actions = $this->actionRepository->getActionsOfRoles($role_ids);

      return 
      [
        'user' => $user, 
        'units' => $units,
        'roles'=> $roles,
        'applications'=> $applications,
        'menus'=> $menus,
        'actions'=> $actions,
      ];

  }

  public function getForOptions($filters)
  {
    $result = $this->userRepo->getForOptions($filters);
    return $result;
  }

  public function myUser($id)
  {
    $result = $this->userRepo->myUser($id);
    return $result;
  }

  public function getWithRoleMenu($id){
    $user = $this->userRepo->getWithRoleMenu($id);

    $flatUser = [
      "id"=> $user['id'],
      "username"=> $user['username'],
      "name"=> $user['name'],
      "roles"=> [],
      "applications"=> [],
    ];

      $roles = [];
      $applications = [];     

      foreach ($user['roles'] as $role) {
        $cloneRole = [
          'id'=>$role['id'],'name'=>$role['name']
        ];
        array_push($flatUser['roles'], $cloneRole);
          foreach ($role['applications'] as $app) {
            $cloneApp = [
              'id'=>$app['id'],'name'=>$app['name']
            ];
            array_push($flatUser['applications'], $cloneApp);            
          }
      }
      
    return $flatUser;
  }

  public function store($request){

    $data = [
      'username'=>$request->username,
      'name'=>$request->name,
      'email'=>$request->email,
      'password'=> bcrypt($request->username),
      'user_type_value'=>$request->user_type_value
    ];

    $result = $this->userRepo->store($data);

    if($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }

  }

  public function changePassword($user_id, $newPassword){
    $data = [
      'password'=> bcrypt($newPassword)
    ];
    $result = $this->userRepo->update('id', $user_id, $data);
    return $result;
  }

  public function resetPassword($user_id){
    $user = $this->userRepo->getById($user_id);

    $data = [
      'password'=> bcrypt($user->username)
    ];
    $result = $this->userRepo->update('id', $user_id, $data);
    return $result;
  }

  public function createUser($data){
    
    $data['password'] = bcrypt($data['username']);
    $this->userRepository->insertUser($data);
  }

  public function storeOfEmployes($request){

    foreach($request->employes as $row){

      $data = [
        'id'=>$row['key_id'],
        'name'=>$row['emp_name'],
        'username'=>$row['emp_id'],
        'emp_id'=>$row['emp_id'],
        'emp_status'=>$row['emp_status'],
        'user_type_value'=>1,
        'password'=> bcrypt($row['emp_id'])
      ];

      $userUnits = [
        'user_id'=>$row['key_id'],
        'unit_id'=>$row['unit_id']
      ];


      $result = $this->userRepo->store($data);
      $result = $this->userRepo->storeUserUnit($userUnits);


    }
  }

  public function addRole($id, $data){

    $user = User::find($id);
    $user->roles()->attach($data);
    $data = $user->save();

    if ($data) {
      return response()->json(['message' => 'add data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function addUnit($id, $data){

    $user = User::find($id);
    $user->units()->attach($data);
    $data = $user->save();

    if ($data) {
      return response()->json(['message' => 'add data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function edit($id)
  {
    $result = $this->userRepo->edit($id);
    return $result;
  }

  public function update($column_id, $id, $data)
  {
    $newData = $data;
    if($data['username']!==null){
      $newData['password'] = bcrypt($data['username']);
    }else{
      unset($newData['username']);
    }
    
    
    $result = $this->userRepo->update($column_id, $id, $newData);
    return $result;
  }
  

  public function destroy($request)
  {
    $request->validate([
      'ids' => 'required',
    ]);

    $result = $this->userRepo->destroy($request);
    return $result;
  }

}