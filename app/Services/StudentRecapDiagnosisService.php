<?php

namespace App\Services;
use App\Repositories\StudentRecapDiagnosisRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class StudentRecapDiagnosisService{
    protected $studentRecapDiagnosisRepository;

    public function __construct(StudentRecapDiagnosisRepository $studentRecapDiagnosisRepository){
	    $this->studentRecapDiagnosisRepository = $studentRecapDiagnosisRepository;
    }

    public function dataMCU($request){
    $result = $this->studentRecapDiagnosisRepository->dataMCU($request);
    return $result;
    }

    public function dataTreatment($request){
    $result = $this->studentRecapDiagnosisRepository->dataTreatment($request);
    return $result;
    }
        
}
