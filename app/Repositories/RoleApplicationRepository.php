<?php

namespace App\Repositories;

use App\Models\RoleApplication;
use Illuminate\Support\Facades\DB;

class RoleApplicationRepository
{

  protected $roleApplication;

  public function __construct(RoleApplication $roleApplication)
  {
    $this->roleApplication = $roleApplication;
  }

  public function data($request)
  {
    return  $this->roleApplication::with(['role', 'application'])->orderBy('role_id', 'ASC')
      ->when(isset($request['name_application']), function ($query)  use ($request) {
        $query->WhereHas('application', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_application'] . '%');
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
    $result = RoleApplication::create([
      'role_id' => $data->role_id,
      'application_id' => $data->application_id
    ]);
    return $result;
  }

  public function edit($id)
  {
    $result = RoleApplication::where('id', $id)->first();
    return $result;
  }

  public function update($data)
  {
    $id = $data->id;
    $result = RoleApplication::where('id', $id)->update([
      'role_id' => $data->role_id,
      'application_id' => $data->application_id,
    ]);

    return $result;
  }

  public function destroy($data)
  {
    $id = $data->id;
    $result = RoleApplication::destroy($id);
    return $result;
  }
}
