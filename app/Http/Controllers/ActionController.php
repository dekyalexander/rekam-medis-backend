<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActionService;

class ActionController extends Controller
{
  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $actionService;

  public function __construct(ActionService $actionService)
  {
    $this->actionService = $actionService;
  }

  public function data(Request $request)
  {
    $reqParams = $request->all();
 
    try {
      $query = $this->actionService->data($reqParams);

      if ($request->page) {
        $result = $query->paginate($request->rowsPerPage);
      } else {
        $result = $query->get();
      }

      return response($result);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getApproverOfAction(Request $request)
  {

    try {
      $query = $this->actionService->getApproverOfAction($request->action_id);

      return response($query);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getForOptions(Request $request)
  {
    $reqParams = $request->all();
 
    try {
      $query = $this->actionService->getForOptions($reqParams);
      return response($query->get());
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getForRoles(Request $request)
  {
    $reqParams = $request->all();
 
    try {
      $query = $this->actionService->getForRoles($reqParams);
      return response($query->get());
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function store(Request $request)
  {
    $request->validate([
      'code' => 'required',
      'name' => 'required',
      'menu_id' => 'required',
      'application_id' => 'required',
      'need_approval' => 'required',
    ]);

    $result = $this->actionService->store($request->all());

    if ($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }
  }

  public function addApprover(Request $request)
    {
        try {
            $result = $this->actionService->addApprover(
                $request->action_id, 
                $request->role_id, 
                $request->level
            );
            if ($result==='save') {
              return response(['message' => 'stored data'], $this->success);
            } else {
              return response()->json(['errors' => ['store' => 'duplicated']], $this->error);
            }
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage(), 'message' => 'stored data']);
        }
        
    }

  public function update(Request $request)
  {

    $request->validate([
      'code' => 'required',
      'name' => 'required',
      'menu_id' => 'required',
      'application_id' => 'required',
      'need_approval' => 'required'
    ]);

    $result = $this->actionService->update($request);

    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function destroy(Request $request)
  {

    $request->validate([
      'ids' => 'required',
    ]);
    
    return $this->actionService->destroy($request->ids);
  }

  public function deleteApprover(Request $request)
  {
    $request->validate([
      'action_id' => 'required',
      'role_ids' => 'required',
    ]);
    
    return $this->actionService->deleteApprover($request->action_id, $request->role_ids);
  }
}
