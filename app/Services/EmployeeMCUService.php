<?php

namespace App\Services;
use App\Repositories\EmployeeMCURepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EmployeeMCUService{
    protected $employeemcuRepository;

    public function __construct(EmployeeMCURepository $employeemcuRepository){
	    $this->employeemcuRepository = $employeemcuRepository;
    }

    public function getEmployeeMCUOptions($filters, $rowsPerPage=25){
	    return $this->employeemcuRepository->getEmployeeMCUOptions($filters)->paginate($rowsPerPage);
    }

    public function createDataEmployeeMCU($data_employee_mcu){
        return $this->employeemcuRepository->insert($data_employee_mcu);
    }


    public function createGeneralDiagnosis($data_general_diagnosis){
        $this->employeemcuRepository->insert1($data_general_diagnosis);
    }

    public function updateDataEmployeeMCU($data_employee_mcu, $id){
        return $this->employeemcuRepository->update($data_employee_mcu, $id);
    }

    public function updateGeneralDiagnosis($data_to_service, $id, $id_diagnosis){
        if($id_diagnosis!=''){
          $response = $this->employeemcuRepository->update1($data_to_service, $id_diagnosis);
        }else {
            $data_to_service = [
                                  'employee_mcu_id'=> $id,
                                  'diagnosis_id'=> $data_to_service['diagnosis_id'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->employeemcuRepository->insertUpdate1($data_to_service);
        }

        return $response;
    }

    public function deleteEmployeeMCU($ids){
      $this->employeemcuRepository->deleteEmployeeMCU($ids);          
    }
        
}
