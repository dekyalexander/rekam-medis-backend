<?php

namespace App\Repositories;

use App\Models\DrugUnit;
use Carbon\Carbon;

class DrugUnitRepository{
  protected $drugunit;

  public function __construct(DrugUnit $drugunit){
    $this->drugunit = $drugunit;
  }

  public function getDrugUnitById($id,$selects=['*']){
    return DrugUnit::select($selects)
    ->where('id','=',$id);
  }

  public function getDrugUnitByCode($drugunit){
    return DrugUnit::
    where('drug_unit','=',$drugunit)
    ->count();
  } 

  public function getDrugUnitOptions($filters){
    return DrugUnit::select('id', 'drug_unit', 'created_at')
    ->when(isset($filters['drug_unit']), function ($query) use ($filters) {
      return $query->where('drug_unit','like','%'.$filters['drug_unit'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    })->orderBy('drug_unit');
  }

  public function insert($data){
    DrugUnit::insert($data);
  }

  public function updateDrugUnit($data,$id){
    DrugUnit::where('id', $id)
            ->update($data);
  }
  
  public function deleteDrugUnit($ids){
    DrugUnit::whereIn('id', $ids)
            ->delete();
  }


}
