<?php

namespace App\Services;

use App\Repositories\UnitRepository;

class UnitService
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  
  protected $unitRepo;

  public function __construct(UnitRepository $unitRepo)
  {
    $this->unitRepo = $unitRepo;
  }

  public function data($request)
  {
    $result = $this->unitRepo->data($request);
    return $result;
  }

  public function getForOptions()
  {
    return $this->unitRepo->getForOptions();
  }

  public function storeOfEmployes($request){

    foreach($request->units as $row){

      $data = [
        'id'=>$row['unit_id'],
        'name'=>$row['unit_name'],
        'unit_type_value'=>$row['unit_type'],
        'head_role_id'=>$row['unit_under_id'],
      ];

      $result = $this->unitRepo->store($data);

    }
  }

  public function store($data)
  {
    $result = $this->unitRepo->store($data);

    if ($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }
  }

  public function edit($id)
  {
    $result = $this->unitRepo->edit($id);
    return $result;
  }

  public function update($request)
  {

    $request->validate([
      'id' => 'required',
      'name' => 'required',
      'head_role_id' => 'required'
    ]);

    $result = $this->unitRepo->update($request);
    return $result;
  }

  public function destroy($request)
  {
    $request->validate([
      'ids' => 'required',
    ]);

    $result = $this->unitRepo->destroy($request);
    return $result;
  }
}
