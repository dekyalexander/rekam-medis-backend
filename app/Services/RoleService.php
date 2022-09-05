<?php

namespace App\Services;
use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleService {

  protected $roleRepo;

  public function __construct(RoleRepository $roleRepo){
    $this->roleRepo = $roleRepo;
  }

  public function data($request){
    $result = $this->roleRepo->data($request);
    return $result;
  }

  public function getForOptions($request){
    return $this->roleRepo->getForOptions($request);
  }

  public function getUsersOfRole($role_id){
    $role = $this->roleRepo->getById($role_id);
    return $role->users()->get();
  }

  public function getApprovalsOfRole($role_id){
    $role = $this->roleRepo->getById($role_id);
    return $role->approvals()->with(['menu','application','role_level'])->get();
  }

  public function store($data){
    $result = $this->roleRepo->store($data);
    return $result;
  }

  public function addApproval($role_id, $action_id, $level){

    $exists = Role::whereHas('approvals', function ($query) use ($role_id, $action_id) {
      $query->where('role_id', $role_id);
      $query->where('action_id', $action_id);
    })->count();

    if($exists===0){
      $role = $this->roleRepo->getById($role_id);
      $role->approvals()->attach($action_id, ['level' => $level]);
      $role->save();
      return 'save';
    }else{
      return 'duplicate';
    }

  }

  public function storePriviledge($request){

    $result = $this->roleRepo->storeRoleApplication($request->role_id, $request->applications);
    $result = $this->roleRepo->storeRoleMenu($request->role_id, $request->menus);
    $result = $this->roleRepo->storeRoleAction($request->role_id, $request->actions);

    return $result;
  }

  public function addUserOfRole($role_id, $user_ids){

    $result = $this->roleRepo->addUserOfRole($role_id, $user_ids);

    return $result;
  }

  public function deleteUserOfRole($role_id, $user_ids){

    $role = $this->roleRepo->getById($role_id);
    return $role->users()->detach($user_ids);
  }

  public function deleteApprovalOfRole($role_id, $action_ids){

    $role = $this->roleRepo->getById($role_id);
    return $role->approvals()->detach($action_ids);

  }

  public function detail($id){
    $result = $this->roleRepo->detail($id);
    return $result;
  }

  public function update($id, $data){
    $result = $this->roleRepo->update($id, $data);
    return $result;
  }

  public function destroy($request){
    $result = $this->roleRepo->destroy($request);
    return $result;
  }

}
