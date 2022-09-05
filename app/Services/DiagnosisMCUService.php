<?php

namespace App\Services;
use App\Repositories\DiagnosisMCURepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DiagnosisMCUService{
    protected $diagnosismcuRepository;

    public function __construct(DiagnosisMCURepository $diagnosismcuRepository){
	    $this->diagnosismcuRepository = $diagnosismcuRepository;
    }

    public function getDiagnosisMCUOptions($filters){
	    return $this->diagnosismcuRepository->getDiagnosisMCUOptions($filters)->get();
    }

    // public function createDiagnosisMCU($data){
    //   $this->diagnosismcuRepository->insert($data);
  	// }

    public function createDiagnosisMCU($data){
      if ($this->diagnosismcuRepository->getDiagnosisMCUByCode($data['diagnosis_kode'],$data['diagnosis_name']) < 1) {
        $this->diagnosismcuRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDiagnosisMCU($data, $id){
      $this->diagnosismcuRepository->updateDiagnosisMCU($data, $id);
    }

    public function deleteDiagnosisMCU($ids){
      $this->diagnosismcuRepository->deleteDiagnosisMCU($ids);          
    }
        
}
