<?php

namespace App\Repositories;

use App\Models\Transactions;
use App\Models\DrugName;
use App\Models\ListOfUKSLocations;
use Carbon\Carbon;

class DrugRecapRepository{
  protected $drugrecap;

  public function __construct(Transactions $drugrecap){
    $this->drugrecap = $drugrecap;
  }

  public function getDrugRecapOptions($request)
  {
    return $this->drugrecap->with(['drugname:id,drug_kode,drug_name','listofukslocations:id,uks_name'])
            ->when(isset($request['location_id']), function ($query) use ($request) {
              return $query->Where('location_id', $request['location_id']);
            })
            ->when(isset($request['created_at']), function ($query) use ($request) {
              return $query->whereDate('created_at','<=', $request['created_at']);
            })
            ->when(isset($request['updated_at']), function ($query) use ($request) {
              return $query->whereDate('updated_at','>=', $request['updated_at']);
            })
            ->orderBy('drug_id', 'ASC');
  }

}
