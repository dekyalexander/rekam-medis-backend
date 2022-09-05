<?php

namespace App\Repositories;

use App\Models\RoleMenu;
use Illuminate\Support\Facades\DB;

class RoleMenuRepository
{

  protected $roleMenu;

  public function __construct(RoleMenu $roleMenu)
  {
    $this->roleMenu = $roleMenu;
  }

  public function data($request)
  {
    return $this->roleMenu::with(['menus'])->orderBy('role_id', 'ASC')
      ->when(isset($request['name_roles']), function ($query)  use ($request) {
        $query->WhereHas('role', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_roles'] . '%');
        });
      })
      ->when(isset($request['name_menus']), function ($query)  use ($request) {
        $query->OrWhereHas('application', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_menus'] . '%');
        });
      });
  }

  // $keys = [
  //   'name_roles' => $request->keyword,
  //   'name_menus' => $request->keyword,
  // ];

  public function store($data)
  {
    $result = RoleMenu::create([
      'menu_id' => $data->menu_id,
      'role_id' => $data->role_id
    ]);
    return $result;
  }

  public function edit($id)
  {
    $result = RoleMenu::where('id', $id)->first();
    return $result;
  }

  public function update($data)
  {
    $id = $data->id;
    $result = RoleMenu::where('id', $id)->update([
      'menu_id' => $data->menu_id,
      'role_id' => $data->role_id
    ]);

    return $result;
  }

  public function destroy($data)
  {
    $id = $data->id;
    $result = RoleMenu::destroy($id);
    return $result;
  }
}
