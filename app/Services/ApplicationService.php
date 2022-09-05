<?php

namespace App\Services;

use App\Repositories\ApplicationRepository;
use App\Repositories\MenuRepository;

class ApplicationService
{
  protected $applicationRepo;
  protected $menuRepo;

  public function __construct(ApplicationRepository $applicationRepo, MenuRepository $menuRepo)
  {
    $this->applicationRepo = $applicationRepo;
    $this->menuRepo = $menuRepo;
  }

  public function data($request)
  {
    $result = $this->applicationRepo->data($request);
    return $result;
  }

  public function store($request)
  {
    $result = $this->applicationRepo->store($request->all());
    return $result;
  }

  public function addMenuOfApplication($request){

    $result = $this->applicationRepo->addMenuOfApplication($request->application_id, $request->menu_ids);

    return $result;
  }

  public function updateForAplicationMenu($menu_id, $data)
  {
    $result = $this->applicationRepo->updateForAplicationMenu($menu_id, $data);
    return $result;
  }

  public function edit($id)
  {
    $result = $this->applicationRepo->edit($id);
    return $result;
  }

  public function getForOptions()
  {
    return $this->applicationRepo->getForOptions();
  }  

  public function getMenusOfApplication($application_id)
  {
    return $this->menuRepo->getByColumn('application_id', '=', $application_id)->get();
  }

  public function update($id, $data)
  {
    $result = $this->applicationRepo->update($id, $data);
    return $result;
  }

  public function destroy($request)
  {
    $result = $this->applicationRepo->destroy($request);
    return $result;
  }
}
