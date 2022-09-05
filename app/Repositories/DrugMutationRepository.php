<?php

namespace App\Repositories;

use App\Models\DrugDistribution;
// use App\Models\DrugMutation;
use App\Models\DrugName;
use App\Models\ListOfUKSLocations;
use Carbon\Carbon;

class DrugMutationRepository{
  protected $drugmutation;

  public function __construct(DrugDistribution $drugmutation){
    $this->drugmutation = $drugmutation;
  }

  // public function getDrugMutationOptions($filters)
  // {
  //   return $this->drugmutation->with(['drugdistribution.drugname','drugdistribution.locationdrug.listofukslocations'])
  //           ->when(isset($filters['location_id']), function ($query) use ($filters) {
  //             return $query->Where('location_id', $filters['location_id']);
  //           })
  //           ->when(isset($filters['created_at']), function ($query) use ($filters) {
  //             return $query->whereDate('created_at','<=', $filters['created_at']);
  //           })
  //           ->when(isset($filters['updated_at']), function ($query) use ($filters) {
  //             return $query->whereDate('updated_at','>=', $filters['updated_at']);
  //           })
  //           ->orderBy('drug_id', 'ASC');
  // }

   public function getDrugMutationOptions($filters)
  {
    $drug_name = $filters['keyword'];
    $query = $this->drugmutation->with(['drugname:id,drug_kode,drug_name',
    'drugtype:id,drug_type',
    'drugunit:id,drug_unit',
    'drugexpired:id,date_expired,drug_id',
    'listofukslocations:id,uks_name'])
    ->when(isset($filters['location_id']), function ($query) use ($filters) {
        return $query->Where('location_id', $filters['location_id']);
    })
    ->when(isset($filters['drug_id']), function ($query) use ($filters) {
        $query->WhereHas('drugname', function ($q) use ($filters) {
          return $q->where('drug_name', $filters['drug_id']);
        });
    })
    ->when(isset($filters['drug_type_id']), function ($query) use ($filters) {
        return $query->Where('drug_type_id', $filters['drug_type_id']);
    })
     ->when(isset($filters['created_at']), function ($query) use ($filters) {
        return $query->WhereDate('created_at','<=', $filters['created_at']);
    })
    ->when(isset($filters['updated_at']), function ($query) use ($filters) {
        return $query->WhereDate('updated_at','>=', $filters['updated_at']);
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','like','%'.$filters['id'].'%');
    });
    if($drug_name){
                $query->WhereHas('drugname', function ($q) use($drug_name) {
                  return $q->where('drug_name','like','%'.$drug_name.'%');
                });
              }
    return $query;
  }

  public function insertDataDrugMutation($data_drug){
    DrugMutation::insert($data_drug);
  }

  public function updateDataDrugMutation($data_drug, $id){
    DrugDistribution::where('id', $id)->update($data_drug);
  }


}
