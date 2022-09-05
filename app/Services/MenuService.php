<?php

namespace App\Services;

use App\Repositories\MenuRepository;
use App\Repositories\ActionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ApprovalRepository;
use Illuminate\Http\Request;

class MenuService
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $menuRepo;
  protected $actionRepo;
  protected $roleRepo;
  protected $approvalRepo;

  public function __construct(ApprovalRepository $approvalRepo, RoleRepository $roleRepo, MenuRepository $menuRepo, ActionRepository $actionRepo)
  {
    $this->approvalRepo = $approvalRepo;
    $this->roleRepo = $roleRepo;
    $this->menuRepo = $menuRepo;
    $this->actionRepo = $actionRepo;
  }

  public function data($request)
  {
    $result = $this->menuRepo->data($request);
    return $result;
  }

  public function getForOptions($request)
  {
    return $this->menuRepo->getForOptions($request);
  }

  public function getRoleOfMenu($request)
  {
    return $this->menuRepo->getRoleOfMenu($request);
  }

  public function getActionOfMenu($request)
  {
      $menu = $this->menuRepo->getById($request->menu_id);
      return $menu->actions()->get();
  }

  public function store($data)
  {
    $result = $this->menuRepo->store($data);


    $menu = $this->menuRepo->getById($result->id);

    $read = [
      'code' => 'READ',
      'name' => 'read',
      'menu_id' => $result->id,
      'need_approval' => 1,
      'application_id' => $menu->application_id,
      'approval_type_value' => 1
    ];

    $create = [
      'code' => 'CREATE',
      'name' => 'create',
      'menu_id' => $result->id,
      'need_approval' => 1,
      'application_id' => $menu->application_id,
      'approval_type_value' => 1
    ];

    $edit = [
      'code' => 'EDIT',
      'name' => 'edit',
      'menu_id' => $result->id,
      'need_approval' => 1,
      'application_id' => $menu->application_id,
      'approval_type_value' => 1
    ];

    $this->actionRepo->store($read);
    $this->actionRepo->store($create);
    $this->actionRepo->store($edit);

    if ($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }
    
  }

  public function update($request)
  {
    if($request->data){
      $data = [];
      foreach($request->data as $reqData){
        array_push($data, ['id'=>$reqData['id'], 'data'=>$reqData]);
      }
      $result = $this->menuRepo->updateMultiple($data);
    }else{
      $id = $request->id;
      $data = $request->all();
      $result = $this->menuRepo->update($id, $data);
    }

    return $result;
  }

  public function addMenuOfApplication($menu_ids, $data){

    foreach($menu_ids as $id){
      $result = $this->menuRepo->update($id, $data);
    }
    return $result;
  }

  public function destroy($menu_ids)
  {
    $action_ids = $this->actionRepo->getActionsByMenuIds($menu_ids)->pluck('id');
    
    $this->approvalRepo->deleteApprovalByActionIds($action_ids);
    $this->roleRepo->deleteRoleWithActions($action_ids);
    $this->roleRepo->deleteRoleWithApprovals($action_ids);
    $this->actionRepo->destroy($action_ids);

    $this->roleRepo->deleteRoleWithMenus($menu_ids);

    $result = $this->menuRepo->destroy($menu_ids);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }
  }
}
