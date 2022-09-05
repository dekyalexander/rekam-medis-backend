<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\Action;
use Illuminate\Support\Facades\DB;

class MenuRepository
{

  protected $menu;

  public function __construct(Menu $menu)
  {
    $this->menu = $menu;
  }

  public function getById($id){
    return $this->menu->find($id);
  }

  public function data($request)
  {
    return $this->menu->with(['children:id,name','parent:id,name','application:id,name','actions:id,code,name'])
            ->when(isset($request['menu_id']), function ($query) use ($request) {
                return $query->where('id', '=', $request['menu_id']);
              })
            ->when(isset($request['not_menu_id']), function ($query) use ($request) {
                return $query->where('id', '<>', $request['not_menu_id']);
              })
            ->when(isset($request['application_id']), function ($query) use ($request) {
                return $query->where('application_id', '=', $request['application_id']);
              })
            ->orderBy('name', 'ASC');
  }

  public function getByColumn($column, $operator, $value){
    return $this->menu->where($column, $operator, $value);
  }

  public function getForOptions($request)
  {
    return $this->menu->with(['children:id,name','parent:id,name','application:id,name'])->select('id', 'name', 'application_id')
    ->when(isset($request['application_id']), function ($query) use ($request) {
      return $query->orWhere('application_id', $request['application_id']);
    })
    ->when(isset($request['not_application_id']), function ($query) use ($request) {
      return $query->orWhere('application_id', '<>', $request['not_application_id']);
    });
  }

  public function getRoleOfMenu($request)
  {
    return $this->menu->with(['children:id,name','parent:id,name','application:id,name', 'roles'])
            ->select('id', 'name', 'application_id')
            ->when(isset($request['application_id']), function ($query) use ($request) {
              return $query->orWhere('application_id', $request['application_id']);
            })
            ->when(isset($request['not_application_id']), function ($query) use ($request) {
              return $query->orWhere('application_id', '<>', $request['not_application_id']);
    });
  }

  public function getActionOfMenu($request)
  {
    return $this->menu
      ->when(isset($request['menu_id']), function ($query) use ($request) {
        return $query->orWhere('id', $request['menu_id']);
      });
  }

  public function getMenusOfRoles($role_ids)
  {
    return Menu::with(['children' => function($q) use ($role_ids){
                        $q->whereHas('roles', function ($query) use ($role_ids) {
                          $query->whereIn('roles.id', $role_ids );
                        });
                      }])
                      ->whereHas('roles', function ($query) use ($role_ids) {
                        $query->whereIn('roles.id',$role_ids );
                      })
                      ->orderBy('name','ASC')
                      ->get();
  }

  public function store($data)
  {
    $result = Menu::create($data);
    return $result;
  }


  public function update($id, $data)
  {
    $result = Menu::where('id', $id)->update($data);
    return $result;
  }

  public function updateMultiple($data){
    foreach ($data as $menu) {
      $result = Menu::where('id', $menu['id'])->update($menu['data']);
    }

    return $result;
  }

  public function destroy($menu_ids)
  {

    $result = Menu::destroy($menu_ids);

    return $result;
  }
}
