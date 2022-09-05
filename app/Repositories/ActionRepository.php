<?php

namespace App\Repositories;

use App\Models\Action;
use Illuminate\Support\Facades\DB;

class ActionRepository
{

  protected $action;

  public function __construct(Action $action)
  {
    $this->action = $action;
  }

  public function getById($id){
    return $this->action->find($id);
  }

  public function getActionsByMenuIds($menu_ids){
    return $this->action->whereIn('menu_id',$menu_ids);
  }


  public function data($request)
  {
    return  $this->action->with(['application:id,name','menu:id,name'])
      ->when(isset($request['name']), function ($query) use ($request) {
        return $query->orWhere('name', $request['name']);
      })
      ->when(isset($request['menu_id']), function ($query) use ($request) {
        return $query->Where('menu_id', $request['menu_id']);
      })
      ->when(isset($request['application_id']), function ($query) use ($request) {
        return $query->Where('application_id', $request['application_id']);
      })->orderBy('name', 'ASC');
  }

  public function getForOptions($request)
  {
    return $this->action->select('id', 'code', 'name', 'menu_id')
      ->when(isset($request['menu_id']), function ($query) use ($request) {
        return $query->orWhere('menu_id', $request['menu_id']);
      })
      ->when(isset($request['not_menu_id']), function ($query) use ($request) {
        return $query->orWhere('menu_id', '<>', $request['not_menu_id']);
      });
  }

  public function getForRoles($request)
  {
    return $this->action->with(['roles'])->select('id', 'code', 'name', 'menu_id')
      ->when(isset($request['menu_id']), function ($query) use ($request) {
        return $query->orWhere('menu_id', $request['menu_id']);
      })
      ->when(isset($request['not_menu_id']), function ($query) use ($request) {
        return $query->orWhere('menu_id', '<>', $request['not_menu_id']);
      });
  }

   
  public function getActionsOfRoles($role_ids)
  {
    return Action::whereHas('roles', function ($query) use ($role_ids) {
      $query->whereIn('roles.id',$role_ids );
    })->get();
  }

  public function store($data)
  {
    $result = Action::create($data);
    return $result;
  }

  public function update($id, $data)
  {

    $result = Action::where('id', $id)->update($data);

    return $result;
  }

  public function destroy($action_ids)
  {

    $result = Action::destroy($action_ids);

    return $result;
  }

  public function deleteActionsByMenuIds($menu_ids)
  {

    $result = Action::whereIn('menu_id',$menu_ids)->delete();

    return $result;
  }
}
