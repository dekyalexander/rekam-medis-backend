<?php

namespace App\Services;
use App\Repositories\DiagnosisBMIRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DiagnosisBMIService{
    protected $diagnosisbmiRepository;

    public function __construct(DiagnosisBMIRepository $diagnosisbmiRepository){
	    $this->diagnosisbmiRepository = $diagnosisbmiRepository;
    }

    public function getDiagnosisBMIOptions($filters){
	    return $this->diagnosisbmiRepository->getDiagnosisBMIOptions($filters)->get();
    }

    // public function createDiagnosisBMI($data){
    //   $this->diagnosisbmiRepository->insert($data);
  	// }

    public function createDiagnosisBMI($data){
      if ($this->diagnosisbmiRepository->getDiagnosisBMIByCode($data['diagnosis_kode'],$data['diagnosis_name']) < 1) {
        $this->diagnosisbmiRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDiagnosisBMI($data, $id){
      $this->diagnosisbmiRepository->updateDiagnosisBMI($data, $id);
    }

    public function deleteDiagnosisBMI($ids){
      $this->diagnosisbmiRepository->deleteDiagnosisBMI($ids);          
    }
        
}
