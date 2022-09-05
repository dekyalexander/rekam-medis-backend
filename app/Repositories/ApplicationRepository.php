<?php

namespace App\Repositories;

use App\Models\Application;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class ApplicationRepository
{
  protected $application;

  public function __construct(Application $application)
  {
    $this->application = $application;
  }

  public function data($request)
  {
    return  $this->application->with(['menus'])->orderBy('name', 'ASC')
      ->when(isset($request['application_id']), function ($query) use ($request) {
        return $query->where('id', $request['application_id']);
      })
      ->when(isset($request['menu_id']), function ($query) use ($request) {
        $query->whereHas('menus', function ($query) use ($request) {
          return $query->where('id', $request['menu_id']);
        });
      });
  }

  public function getForOptions($filters)
  {
    return $this->application->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->where('name', 'like', '%' . $filters['keyword'] . "%");
    });
  }

  public function getApplicationsOfRoles($role_ids)
  {
    return Application::with('categoryApp.category')
      ->whereHas('roles', function ($query) use ($role_ids) {
        $query->whereIn('roles.id', $role_ids);
      })->get();
  }


  public function store($data)
  {
    $result = Application::create($data);
    return $result;
  }

  public function addMenuOfApplication($id, $data)
  {
    $app = Application::find($id);
    $exists = $app->menus->contains($id);
    if (!$exists == 1) {
      $app->menus()->attach($data);
      return $app->save();
    }
  }

  public function updateForAplicationMenu($id, $data)
  {
    $result = Menu::WHERE('id', $id)->update($data);
  }

  public function edit($id)
  {
    $result = Application::WHERE('id', $id)->get();
    return $result;
  }

  public function update($id, $data)
  {
    $result = Application::WHERE('id', $id)->update($data);

    return $result;
  }

  public function destroy($data)
  {
    $id = $data->id;
    $result = Application::destroy($id);
    return $result;
  }
}
