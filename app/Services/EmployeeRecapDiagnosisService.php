<?php

namespace App\Services;
use App\Repositories\EmployeeRecapDiagnosisRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EmployeeRecapDiagnosisService{
    protected $employeeRecapDiagnosisRepository;

    public function __construct(EmployeeRecapDiagnosisRepository $employeeRecapDiagnosisRepository){
	    $this->employeeRecapDiagnosisRepository = $employeeRecapDiagnosisRepository;
    }

    public function dataTreatment($request){
    $result = $this->employeeRecapDiagnosisRepository->dataTreatment($request);
    return $result;
    }

    public function dataMCU($request){
    $result = $this->employeeRecapDiagnosisRepository->dataMCU($request);
    return $result;
    }
        
}
