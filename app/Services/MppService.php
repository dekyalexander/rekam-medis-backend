<?php

namespace App\Services;

use App\Repositories\MppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class MppService
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $mppRepository;

  public function __construct(MppRepository $mppRepository)
  {
    $this->mppRepository = $mppRepository;
  }

  public function getData($requestParams, $rowsPerPage , $page )
  {
    $query = $this->mppRepository->getData($requestParams);
    if ( $page) {
      $result = $query->paginate($rowsPerPage);
    } else {
      $result = $query->get();
    }
    return $result;
  }




  // public function getForOptions($request)
  // {
  //   return $this->menuRepo->getForOptions($request);
  // }

  // public function getRoleOfMenu($request)
  // {
  //   return $this->menuRepo->getRoleOfMenu($request);
  // }

  // public function getActionOfMenu($request)
  // {
  //     $menu = $this->menuRepo->getById($request->menu_id);
  //     return $menu->actions()->get();
  // }

  public function store($data)
  {

    $validator = Validator::make($data,[
      'tahun_pelajaran' => 'required',
      'validity_period_from' => 'required',
      'validity_period_until' => 'required',
      'description_1' => 'required',
      'publish' => 'required',
      'user_created_id' => 'required',
    ]);

    if($validator->fails()){
      return response()->json(['message' => ["Validation Error."]], $this->error);
      // throw new InvalidArgumentException($validator->errors()->first());
    }

    $result = $this->mppRepository->store($data);
    return $result;
  }

  public function update($data, $id)
  {
    $result = $this->mppRepository->update($id, $data);
    return $result;
  }

  // public function addMenuOfApplication($menu_ids, $data){

  //   foreach($menu_ids as $id){
  //     $result = $this->menuRepo->update($id, $data);
  //   }
  //   return $result;
  // }

  // public function destroy($menu_ids)
  // {
  //   $action_ids = $this->actionRepo->getActionsByMenuIds($menu_ids)->pluck('id');
    
  //   $this->approvalRepo->deleteApprovalByActionIds($action_ids);
  //   $this->roleRepo->deleteRoleWithActions($action_ids);
  //   $this->roleRepo->deleteRoleWithApprovals($action_ids);
  //   $this->actionRepo->destroy($action_ids);

  //   $this->roleRepo->deleteRoleWithMenus($menu_ids);

  //   $result = $this->menuRepo->destroy($menu_ids);

  //   if ($result) {
  //     return response()->json(['message' => 'delete data'], $this->success);
  //   } else {
  //     return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
  //   }
  // }
}
