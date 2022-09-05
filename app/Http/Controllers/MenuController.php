<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Services\ActionService;

class MenuController extends Controller
{
  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $menuService;
  protected $actionService;

  public function __construct(MenuService $menuService, ActionService $actionService )
  {
    $this->menuService = $menuService;
    $this->actionService = $actionService;
  }

  public function data(Request $request)
  {
    $page = $request->page;
    $rowsPerPage = $request->rowsPerPage;

    if (!$rowsPerPage) {
      $rowsPerPage = 10;
    }

    try {
      $query = $this->menuService->data($request);

      if ($request->page) {
        $result = $query->paginate($rowsPerPage);
      } else {
        $result = $query->get();
      }

      return response($result);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getForOptions(Request $request)
  {
    $reqParams = $request->all();

    try {
      $query = $this->menuService->getForOptions($reqParams);
      return response($query->get());
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getRoleOfMenu(Request $request)
  {
    $reqParams = $request->all();

    try {
      $query = $this->menuService->getRoleOfMenu($reqParams);
      return response($query->get());
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getActionOfMenu(Request $request)
  {

    try {
      $query = $this->menuService->getActionOfMenu($request);
      return response($query);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  
 
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'application_id' => 'required',
      'path' => 'required',
      'icon' => 'required',
    ]);

    return $this->menuService->store($request->all());

    
  }


  public function update(Request $request)
  {

    $result = $this->menuService->update($request);
    
    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'changed failed']], $this->error);
    }
  }


  public function deleteActionOfMenu(Request $request){

    $request->validate([
      'action_ids' => ['required'],
    ]);

    return $this->actionService->destroy($request->action_ids);
  }

  public function destroy(Request $request)
  {
    $request->validate([
      'ids' => 'required',
    ]);
    
    
    return $this->menuService->destroy($request->ids);
    
  }
}
