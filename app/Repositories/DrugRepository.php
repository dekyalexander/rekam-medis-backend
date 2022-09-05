<?php

namespace App\Repositories;

use App\Models\DrugLocation;
use App\Models\DrugType;
use App\Models\DrugName;
use App\Models\DrugUnit;
use App\Models\Drug;
use App\Models\Stocks;
use App\Models\DrugExpired;
use App\Models\LocationDrug;
use App\Models\DrugDistribution;
use Carbon\Carbon;

class DrugRepository{
  protected $drug;

  public function __construct(Drug $drug){
    $this->drug = $drug;
  }

  // public function getListUKSLocationById($id,$selects=['*']){
  //   return ListOfUKSLocations::select($selects)
  //   ->where('id','=',$id);
  // }

  // public function getDrug($id,$selects=['*']){
  //   return Drug::select($selects)
  //   ->where('id','=',$id);
  // }

  // public function getDrugByCode($drugtype,$drugname,$drugunit){
  //   return Drug::where('drug_type_id','=',$drugtype)
  //   ->where('drug_name_id','=',$drugname)
  //   ->where('drug_unit_id','=',$drugunit)
  //   ->count();
  // } 

  // public function getDrugLocationByCode($druglocation){
  //   return LocationDrug::
  //   where('location_name','=',$druglocation)
  //   ->count();
  // } 

  // public function getListUKSLocationOptions($filters){
  //   return ListOfUKSLocations::select('id','uks_name')
  //   ->when(isset($filters['uks_name']), function ($query) use ($filters) {
  //     return $query->where('uks_name','like','%'.$filters['uks_name'].'%');
  //   })
  //   ->when(isset($filters['id']), function ($query) use ($filters) {
  //     return $query->where('id','=',$filters['id']);
  //   });
  // }

  // public function getLocationDrugOptions($filters){
  //   return LocationDrug::select('id','location_name','drug_id')
  //   ->when(isset($filters['location_name']), function ($query) use ($filters) {
  //     return $query->where('location_name','like','%'.$filters['location_name'].'%');
  //   })
  //   ->when(isset($filters['id']), function ($query) use ($filters) {
  //     return $query->where('id','=',$filters['id']);
  //   });
  // }


  public function getDrugDistributionOptions($filters){
    return DrugDistribution::with(['drugname:id,drug_kode,drug_name',
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
  }


  public function getDrugDistributionSettings($filters){
    $drug_name = $filters['keyword'];
    $query = DrugDistribution::with(['drugname:id,drug_kode,drug_name',
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

  // public function getDrugDistributionOptions($filters){
  //   return DrugDistribution::select('id','drug_id','location_id','drug_expired_id','drug_type_id','drug_name_id','description','drug_unit_id','qty','created_at','updated_at')
  //   ->with(['drugname'=>function($query){
  //     $query->select('id', 'drug_kode','drug_name');
  //   }])
  //   ->with(['drugtype'=>function($query){
  //     $query->select('id', 'drug_type');
  //   }])
  //   ->with(['drugunit'=>function($query){
  //     $query->select('id', 'drug_unit');
  //   }])
  //   ->with(['drugexpired'=>function($query){
  //     $query->select('id', 'date_expired','drug_id');
  //   }])
  //   ->with('locationdrug.listofukslocations')
  //   // ->with(['locationdrug.listofukslocations'=>function($query){
  //   //   $query->groupBy('location_id');
  //   // }])
  //   ->when(isset($filters['location_id']), function ($query) use ($filters) {
  //       return $query->Where('location_id', $filters['location_id']);
  //   })
  //   ->when(isset($filters['drug_type_id']), function ($query) use ($filters) {
  //       return $query->Where('drug_type_id', $filters['drug_type_id']);
  //   })
  //    ->when(isset($filters['created_at']), function ($query) use ($filters) {
  //       return $query->WhereDate('created_at','<=', $filters['created_at']);
  //   })
  //   ->when(isset($filters['updated_at']), function ($query) use ($filters) {
  //       return $query->WhereDate('updated_at','>=', $filters['updated_at']);
  //   })
  //   ->when(isset($filters['id']), function ($query) use ($filters) {
  //     return $query->where('id','like','%'.$filters['id'].'%');
  //   });
  //   // ->distinct('location_id')->orderBy('id', 'ASC');
  // }

  // $result =  Product::select($selects)->with(['rack.warehouse']);

  //   $warehouse_id = $request['warehouse_id'];

  
  //     $result->WhereHas('rack.warehouse', function ($q) use($warehouse_id) {
  //       return $q->where('id', '=', $warehouse_id);
  //     });


  public function getDrugOptions($filters){
  $drug_name = $filters['keyword'];
   $query = Drug::select('id','drug_type_id','drug_name_id','description','drug_unit_id','location_id','created_at','updated_at')
    ->with(['drugname'=>function($query){
      $query->select('id', 'drug_kode','drug_name');
    }])
    ->with(['drugtype'=>function($query){
      $query->select('id', 'drug_type');
    }])
    ->with(['drugunit'=>function($query){
      $query->select('id', 'drug_unit');
    }])
    ->with(['drugexpired'=>function($query){
      $query->select('id', 'date_expired','drug_id');
    }])
    ->with(['stocks'=>function($query){
      $query->select('id', 'qty','drug_id','location_id','drug_expired_id');
    }])
    ->with('locationdrug.listofukslocations')
    ->when(isset($filters['location_id']), function ($query) use ($filters) {
        return $query->Where('location_id', $filters['location_id']);
    })
     ->when(isset($filters['drug_name_id']), function ($query) use ($filters) {
        return $query->Where('drug_name_id', $filters['drug_name_id']);
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

  //public function getDrugOptions($filters){
    //return Drug::select('id','drug_name','description','unit','created_at')
    //->when(isset($filters['drug_name']), function ($query) use ($filters) {
      //return $query->where('drug_name','like','%'.$filters['drug_name'].'%');
    //})
    //->when(isset($filters['id']), function ($query) use ($filters) {
      //return $query->where('id','=',$filters['id']);
    //});
  //}


  public function insert($data_drug_name){
    $db = Drug::create($data_drug_name);
    return $db->id;
  }

  public function insert2($data_expired_drug){
    $db = DrugExpired::create($data_expired_drug);
    return $db->id;
  }

  public function insert3($data_location_drug){
    $db = LocationDrug::create($data_location_drug);
    return $db->id;
  }

  public function insert4($data_stock_drug){
    Stocks::insert($data_stock_drug);
  }

  public function insert5($data_distribution_drug){
    DrugDistribution::insert($data_distribution_drug);
  }

  public function createDrugDistributionSettings($data_distribution_drug){
    DrugDistribution::insert($data_distribution_drug);
  }

  public function update($data_drug_name, $id){
    Drug::where('id', $id)
            ->update($data_drug_name);
  }

  public function update2($data_expired_drug, $id){
    DrugExpired::where('id', $id)
            ->update($data_expired_drug);
  }

  public function update3($data_location_drug, $id){
    LocationDrug::where('id', $id)
            ->update($data_location_drug);
  }

  public function update4($data_stock_drug, $id){
    Stocks::where('id', $id)
            ->update($data_stock_drug);
  }

  public function updateDrugDistributionSettings($data_drug_distribution, $id){
    DrugDistribution::where('id', $id)
            ->update($data_drug_distribution);
  }

  // public function updateDataDrug($data, $id){
  //   $drug = Drug::with('DrugExpired')
  //   ->with('LocationDrug')
  //   ->with('Stocks')
  //   ->findOrFail($id);

  //   $drug->update($data['drug']);
  //   $drug->DrugExpired->update($data['drug_expired']);
  //   $drug->LocationDrug->update($data['location_drug']);
  //   $drug->Stocks->update($data['stock']);
  // }

  public function deleteDrug($ids){
    Drug::whereIn('id', $ids)
            ->delete();

  }

  public function deleteDrugDistributionSettings($ids){
    DrugDistribution::whereIn('id', $ids)
            ->delete();

  }

}
