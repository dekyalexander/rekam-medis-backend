<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\RoleAction;
use App\Models\RoleApproval;
use App\Models\RoleUser;
use App\Models\RoleMenu;
use Illuminate\Support\Facades\DB;

class RoleRepository
{
  protected $role;

  public function __construct(Role $role)
  {
    $this->role = $role;
  }
    
  public function getById($id){
    return $this->role->find($id);
  }

  public function getRoleByCode($code)
  {
    return $this->role->where('code',$code);
  }

  public function data($request)
  {
    return  $this->role->with(['head_role','data_access:value,name'])
      ->when(isset($request['name']), function ($query) use ($request) {
        return $query->Where('name', $request['name']);
      })->orderBy('name', 'ASC');
  }

  public function getForOptions($request)
  {
    return $this->role->select('id', 'name')
            ->when(isset($request['not_id']), function ($query) use ($request) {
              return $query->orWhere('head_role_id', '<>', $request['not_id']);
            })->get();
  }

  public function getRoleNotId($user_id){

    $query = $this->role::whereDoesntHave('users', function($query) use($user_id) {
      $query->where('users.id', $user_id);
    });

    return $query;

  }

  public function getUsersOfRole($request)
  {
    return $this->role->with(['users'])
    ->when(isset($request['role_id']), function ($query) use ($request) {
      return $query->orWhere('id', $request['role_id']);
    })->get();
  }
 

  public function store($data)
  {
    $result = Role::create($data);
    return $result;
  }

  public function storeRoleApplication($id, $data){
    $role = Role::find($id);
    return $role->applications()->sync($data);
  }

  public function storeRoleMenu($id, $data){
    $role = Role::find($id);
    return $role->menus()->sync($data);
  }

  public function storeRoleAction($id, $data){
    $role = Role::find($id);
    return $role->actions()->sync($data);
  }

  public function addUserOfRole($id, $data){

    $role = Role::with(['users'])->find($id);

    foreach($data as $id){
      $exists = $role->users->contains($id);

      if(!$exists==1){
        $role->users()->attach($data);
        return $role->save();
      }

    }
    
  }

  public function syncUserRole($user_id, $role_id){

    RoleUser::where('user_id',$user_id)
            ->where('role_id',$role_id)->delete();

    RoleUser::insert(['user_id'=>$user_id, 'role_id'=>$role_id]);
    
  }

  public function detail($id)
  {
    $result = Role::with(['head_role','data_access:value,name','applications','menus','actions'])->where('id', $id)->first();
    return $result;
  }

  public function update($id, $data)
  {
    $result = Role::where('id', $id)->update($data);

    return $result;
  }

  public function destroy($data)
  {

    $id = $data->ids;

    $result = Role::destroy($id);

    return $result;
  }

  public function deleteRoleWithMenus($menu_ids)
  {
    return RoleMenu::whereIn('menu_id', $menu_ids)->delete();
  }
  
  public function deleteRoleWithActions($action_ids)
  {
    return RoleAction::whereIn('action_id', $action_ids)->delete();
  }

  public function deleteRoleWithApprovals($action_ids)
  {
    return RoleApproval::whereIn('action_id', $action_ids)->delete();
  }
}
