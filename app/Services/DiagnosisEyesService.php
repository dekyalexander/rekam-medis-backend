<?php

namespace App\Services;
use App\Repositories\DiagnosisEyesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DiagnosisEyesService{
    protected $diagnosiseyesRepository;

    public function __construct(DiagnosisEyesRepository $diagnosiseyesRepository){
	    $this->diagnosiseyesRepository = $diagnosiseyesRepository;
    }

    public function getDiagnosisEyesOptions($filters){
	    return $this->diagnosiseyesRepository->getDiagnosisEyesOptions($filters)->get();
    }

    // public function createDiagnosisEyes($data){
    //   $this->diagnosiseyesRepository->insert($data);
  	// }

    public function createDiagnosisEyes($data){
      if ($this->diagnosiseyesRepository->getDiagnosisEyeByCode($data['diagnosis_kode'],$data['diagnosis_name']) < 1) {
        $this->diagnosiseyesRepository->insert($data);
        return true;
      } else {
        return false;
      }   
  	}

     public function updateDiagnosisEyes($data, $id){
      $this->diagnosiseyesRepository->updateDiagnosisEyes($data, $id);
    }

    public function deleteDiagnosisEyes($ids){
      $this->diagnosiseyesRepository->deleteDiagnosisEyes($ids);          
    }
        
}
