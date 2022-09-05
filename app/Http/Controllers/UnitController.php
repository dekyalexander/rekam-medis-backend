<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UnitService;

class UnitController extends Controller
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $unitService;

  public function __construct(UnitService $unitService)
  {
    $this->unitService = $unitService;
  }

  public function data(Request $request)
  {
    $reqParams = $request->all();

    if ($request->keyword) {
      $keys = ['name' => $request->keyword];
      $reqParams = array_merge($reqParams, $keys);
    }

    try {
      $query = $this->unitService->data($reqParams);

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
      $query = $this->unitService->getForOptions();
      return response($query);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function storeOfEmployes(Request $request)
  {
    return $this->unitService->storeOfEmployes($request);
  }

  public function store(Request $request)
  {

    $request->validate([
      'name' => 'required',
      'head_role_id' => 'required'
    ]);

    return $this->unitService->store($request->all());
    
  }

  public function edit($id)
  {
    $result = $this->unitService->edit($id);
    return $result;
  }

  public function update(Request $request)
  {
    $result = $this->unitService->update($request);

    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function destroy(Request $request)
  {
    $result = $this->unitService->destroy($request);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }
  }
}
