<?php

namespace App\Services;
use App\Repositories\DrugNameRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugNameService{
    protected $drugnameRepository;

    public function __construct(DrugNameRepository $drugnameRepository){
	    $this->drugnameRepository = $drugnameRepository;
    }

    public function getDrugNameOptions($filters){
	    return $this->drugnameRepository->getDrugNameOptions($filters)->get();
    }

    // public function createDrugName($data){
    //   $this->drugnameRepository->insert($data);
  	// }

    public function createDrugName($data){
       if ($this->drugnameRepository->getDrugNameByCode($data['drug_kode'], $data['drug_name']) < 1) {
        $this->drugnameRepository->insert($data);
        return true;
      } else {
        return false;
      }      
  	}

     public function updateDrugName($data, $id){
      $this->drugnameRepository->updateDrugName($data, $id);
    }

    public function deleteDrugName($ids){
      $this->drugnameRepository->deleteDrugName($ids);          
    }
        
}
