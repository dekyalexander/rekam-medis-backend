<?php

namespace App\Services;
use App\Repositories\DrugUnitRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugUnitService{
    protected $drugunitRepository;

    public function __construct(DrugUnitRepository $drugunitRepository){
	    $this->drugunitRepository = $drugunitRepository;
    }

    public function getDrugUnitOptions($filters){
	    return $this->drugunitRepository->getDrugUnitOptions($filters)->get();
    }

    // public function createDrugUnit($data){
    //   $this->drugunitRepository->insert($data);
  	// }

    public function createDrugUnit($data){
      if ($this->drugunitRepository->getDrugUnitByCode($data['drug_unit']) < 1) {
        $this->drugunitRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDrugUnit($data, $id){
      $this->drugunitRepository->updateDrugUnit($data, $id);
    }

    public function deleteDrugUnit($ids){
      $this->drugunitRepository->deleteDrugUnit($ids);          
    }
        
}
