<?php

namespace App\Services;
use App\Repositories\DrugLocationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugLocationService{
    protected $druglocationRepository;

    public function __construct(DrugLocationRepository $druglocationRepository){
	    $this->druglocationRepository = $druglocationRepository;
    }

    public function getDrugLocationOptions($filters){
	    return $this->druglocationRepository->getDrugLocationOptions($filters)->get();
    }

    // public function createDrugLocation($data){
    //   $this->druglocationRepository->insert($data);
  	// }

    public function createDrugLocation($data){
      if ($this->druglocationRepository->getDrugLocationByCode($data['uks_name']) < 1) {
        $this->druglocationRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDrugLocation($data, $id){
      $this->druglocationRepository->updateDrugLocation($data, $id);
    }

    public function deleteDrugLocation($ids){
      $this->druglocationRepository->deleteDrugLocation($ids);          
    }
        
}
