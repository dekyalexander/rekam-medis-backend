<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Services\ApplicationService;
use App\Services\MenuService;

class ApplicationController extends Controller
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $applicationService;
  protected $menuService;

  public function __construct(ApplicationService $applicationService, MenuService $menuService)
  {
    $this->applicationService = $applicationService;
    $this->menuService = $menuService;
  }

  public function data(Request $request)
  {
    $reqParams = $request->all();
    
    try {
      $query = $this->applicationService->data($reqParams);
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

  public function getForOptions()
  {
    try {
      $query = $this->applicationService->getForOptions();
      return response($query->get());
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function getMenusOfApplication(Request $request)
  {
    try {
      return $this->applicationService->getMenusOfApplication($request->application_id);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function store(Request $request)
  {

    $request->validate([
      'code' => ['required', 'min:2'],
      'name' => ['required', 'min:2'],
      'ip' => ['required'],
      'host' => ['nullable'],
    ]);
    
    $result = $this->applicationService->store($request);

    if ($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }
  }

  public function addMenuOfApplication(Request $request){

    $request->validate([
      'application_id' => 'required',
      'menu_ids' => 'required',
    ]);

    $data = [
      'application_id' => $request->application_id
    ];

    $result =  $this->menuService->addMenuOfApplication($request->menu_ids, $data);
    
    if ($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }

  }

  public function deleteMenuOfApplication(Request $request){

    $request->validate([
      'menu_ids' => ['required'],
    ]);

    return $this->menuService->destroy($request->menu_ids);
  }

  public function edit($id)
  {
    $result = $this->applicationService->edit($id);
    return $result;
  }

  public function update(Request $request)
  {

    $request->validate([
      'id' => ['required', 'numeric'],
      'code' => ['required'],
      'name' => ['required', 'min:2'],
      'ip' => ['required'],
      'host' => ['nullable'],
    ]);

    $data = [
      'name' => $request->name,
      'code' => $request->code,
      'ip' => $request->ip,
      'host' => $request->host
    ];

    $result = $this->applicationService->update($request->id, $data);

    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function destroy(Request $request)
  {

    $request->validate([
      'ids' => ['required'],
    ]);

    $result = $this->applicationService->destroy($request);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }
  }
}
