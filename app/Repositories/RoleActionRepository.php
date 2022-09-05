<?php

namespace App\Repositories;

use App\Models\RoleAction;
use Illuminate\Support\Facades\DB;

class RoleActionRepository
{

  protected $roleAction;

  public function __construct(RoleAction $roleAction)
  {
    $this->roleAction = $roleAction;
  }

  public function data($request)
  {
    return $this->roleAction::with(['role', 'action'])->orderBy('role_id', 'ASC')
      ->when(isset($request['name_action']), function ($query)  use ($request) {
        $query->WhereHas('action', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_action'] . '%');
        });
      })
      ->when(isset($request['name_role']), function ($query)  use ($request) {
        $query->OrWhereHas('role', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_role'] . '%');
        });
      });
  }

  public function store($data)
  {
    $result = RoleAction::create([
      'role_id' => $data->role_id,
      'action_id' => $data->action_id
    ]);
    return $result;
  }

  public function edit($id)
  {
    $result = RoleAction::where('id', $id)->first();
    return $result;
  }

  public function update($data)
  {
    $id = $data->id;
    $result = RoleAction::where('id', $id)->update([
      'role_id' => $data->role_id,
      'action_id' => $data->action_id,
    ]);

    return $result;
  }

  public function destroy($data)
  {
    $id = $data->id;
    $result = RoleAction::destroy($id);
    return $result;
  }
}
