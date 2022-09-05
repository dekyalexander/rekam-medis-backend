<?php

namespace App\Services;

use App\Repositories\ActionRepository;
use App\Models\Action;
class ActionService
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;


  protected $actionRepo;

  public function __construct(ActionRepository $actionRepo)
  {
    $this->actionRepo = $actionRepo;
  }

  public function data($request)
  {
    $result = $this->actionRepo->data($request);
    return $result;
  }

  public function getApproverOfAction($id)
  {
    $action = $this->actionRepo->getById($id);
    return $action->approvals()->withPivot('level')->get();
  }
  

  public function getForOptions($request)
  {
    return $this->actionRepo->getForOptions($request);
  }

  public function getForRoles($request)
  {
    return $this->actionRepo->getForRoles($request);
  }

  public function store($data)
  {
    $result = $this->actionRepo->store($data);
    return $result;
  }

  public function addApprover($action_id, $role_id, $level){

    $exists = Action::whereHas('approvals', function ($query) use ($role_id, $action_id) {
      $query->where('role_id', $role_id);
      $query->where('action_id', $action_id);
    })->count();

    if($exists===0){
       $action = $this->actionRepo->getById($action_id);
       $action->approvals()->attach($role_id, ['level' => $level]);
       $action->save();
       return 'save';
    }else{
       return 'duplicate';
    }

  }


  public function update($request)
  {
    $result = $this->actionRepo->update($request->id, $request->all());
    return $result;
  }

  public function destroy($data)
  {
    $result = $this->actionRepo->destroy($data);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }
  }

  public function deleteApprover($action_id, $role_ids){

    $action = $this->actionRepo->getById($action_id);
    $result = $action->approvals()->detach($role_ids);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }

  }
}
