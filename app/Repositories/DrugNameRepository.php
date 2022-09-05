<?php

namespace App\Repositories;

use App\Models\DrugName;
use Carbon\Carbon;

class DrugNameRepository{
  protected $drugname;

  public function __construct(DrugName $drugname){
    $this->drugname = $drugname;
  }

  public function getDrugNameById($id,$selects=['*']){
    return DrugName::select($selects)
    ->where('id','=',$id);
  }

  public function getDrugNameByCode($drugkode,$drugname){
    return DrugName::
    where('drug_kode','=',$drugkode)
    ->where('drug_name','=',$drugname)
    ->count();
  } 

  public function getDrugNameOptions($filters){
    $drug_name_id = $filters['id'];
     $query =  DrugName::select('id', 'drug_kode', 'drug_name', 'created_at')
    ->with(['drugdistribution.locationdrug.listofukslocations'=>function($query){
      $query->select('id', 'uks_name');
    }])
    ->with(['drugdistribution.drugunit'=>function($query){
      $query->select('id', 'drug_unit');
    }])
    ->with(['drugdistribution.drugexpired'=>function($query){
      $query->select('id', 'date_expired');
    }])
    ->when(isset($filters['drug_name']), function ($query) use ($filters) {
      return $query->where('drug_name','like','%'.$filters['drug_name'].'%');
    })->orderBy('drug_name');
    // ->when(isset($filters['id']), function ($query) use ($filters) {
    //     return $query->Where('id', $filters['id']);
    // })
    // ->when(isset($filters['id']), function ($query) use ($filters) {
    //   return $query->where('id','=',$filters['id']);
    // });
    
    if($drug_name_id)
    $query->WhereHas('drugdistribution', function ($q) use($drug_name_id) {
        return $q->where('location_id', '=', $drug_name_id);
    });

  
    return $query;
  }

  public function insert($data){
    DrugName::insert($data);
  }

  public function updateDrugName($data,$id){
    DrugName::where('id', $id)
            ->update($data);
  }
  
  public function deleteDrugName($ids){
    DrugName::whereIn('id', $ids)
            ->delete();
  }


}
