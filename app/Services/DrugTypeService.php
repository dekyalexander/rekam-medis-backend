<?php

namespace App\Services;
use App\Repositories\DrugTypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugTypeService{
    protected $drugtypeRepository;

    public function __construct(DrugTypeRepository $drugtypeRepository){
	    $this->drugtypeRepository = $drugtypeRepository;
    }

    public function getDrugTypeOptions($filters){
	    return $this->drugtypeRepository->getDrugTypeOptions($filters)->get();
    }

    // public function createDrugType($data){
    //   $this->drugtypeRepository->insert($data);
  	// }

     public function createDrugType($data){
      if ($this->drugtypeRepository->getDrugTypeByCode($data['drug_type']) < 1) {
        $this->drugtypeRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDrugType($data, $id){
      $this->drugtypeRepository->updateDrugType($data, $id);
    }

    public function deleteDrugType($ids){
      $this->drugtypeRepository->deleteDrugType($ids);          
    }
        
}
