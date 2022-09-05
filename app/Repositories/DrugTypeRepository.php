<?php

namespace App\Repositories;

use App\Models\DrugType;
use Carbon\Carbon;

class DrugTypeRepository{
  protected $drugtype;

  public function __construct(DrugType $drugtype){
    $this->drugtype = $drugtype;
  }

  public function getDrugTypeById($id,$selects=['*']){
    return DrugType::select($selects)
    ->where('id','=',$id);
  }

  public function getDrugTypeByCode($drugtype){
    return DrugType::
    where('drug_type','=',$drugtype)
    ->count();
  } 

  public function getDrugTypeOptions($filters){
    return DrugType::select('id', 'drug_type', 'created_at')
    ->when(isset($filters['drug_type']), function ($query) use ($filters) {
      return $query->where('drug_type','like','%'.$filters['drug_type'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    })->orderBy('drug_type');
  }

  public function insert($data){
    DrugType::insert($data);
  }

  public function updateDrugType($data,$id){
    DrugType::where('id', $id)
            ->update($data);
  }
  
  public function deleteDrugType($ids){
    DrugType::whereIn('id', $ids)
            ->delete();
  }


}
