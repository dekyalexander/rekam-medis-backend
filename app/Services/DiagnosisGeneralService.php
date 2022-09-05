<?php

namespace App\Services;
use App\Repositories\DiagnosisGeneralRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DiagnosisGeneralService{
    protected $diagnosisgeneralRepository;

    public function __construct(DiagnosisGeneralRepository $diagnosisgeneralRepository){
	    $this->diagnosisgeneralRepository = $diagnosisgeneralRepository;
    }

    public function getDiagnosisGeneralOptions($filters){
	    return $this->diagnosisgeneralRepository->getDiagnosisGeneralOptions($filters)->get();
    }

    // public function createDiagnosisGeneral($data){
    //   $this->diagnosisgeneralRepository->insert($data);
  	// }

    public function createDiagnosisGeneral($data){
      if ($this->diagnosisgeneralRepository->getDiagnosisGeneralByCode($data['diagnosis_kode'],$data['diagnosis_name']) < 1) {
        $this->diagnosisgeneralRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDiagnosisGeneral($data, $id){
      $this->diagnosisgeneralRepository->updateDiagnosisGeneral($data, $id);
    }

    public function deleteDiagnosisGeneral($ids){
      $this->diagnosisgeneralRepository->deleteDiagnosisGeneral($ids);          
    }
        
}
