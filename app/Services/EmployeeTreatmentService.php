<?php

namespace App\Services;
use App\Repositories\EmployeeTreatmentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EmployeeTreatmentService{
    protected $employeetreatmentRepository;

    public function __construct(EmployeeTreatmentRepository $employeetreatmentRepository){
	    $this->employeetreatmentRepository = $employeetreatmentRepository;
    }

    public function getEmployeeTreatmentOptions($filters, $rowsPerPage=25){
	    return $this->employeetreatmentRepository->getEmployeeTreatmentOptions($filters)->paginate($rowsPerPage);
    }

    public function createDataEmployeeTreatment($data_employee_treatment){
        return $this->employeetreatmentRepository->insert($data_employee_treatment);
    }

    public function createGeneralPhysicalExamination($data_general_physical_examination){
        $this->employeetreatmentRepository->insert2($data_general_physical_examination);
    }

    public function createVitalSigns($data_vital_signs){
        $this->employeetreatmentRepository->insert3($data_vital_signs);
    }

    public function createMedicalPrescription($data_medical_prescription){
        $this->employeetreatmentRepository->insert4($data_medical_prescription);
    }

     public function createTransactions($transactions){
        $this->employeetreatmentRepository->insert5($transactions);
    }

     public function createGeneralDiagnosis($data_general_diagnosis){
        $this->employeetreatmentRepository->insert6($data_general_diagnosis);
    }

    public function updateData($data_to_service, $id, $id_medical){
        

        if($id_medical!=''){
          $response = $this->employeetreatmentRepository->update($data_to_service, $id_medical);
        }else {
          $data_to_service = [
                                      'employee_treat_id'=> $id,
                                      'location_id'=> $data_to_service['location_id'],
                                      'drug_id'=> $data_to_service['drug_id'],
                                      'amount_medicine'=> $data_to_service['amount_medicine'],
                                      'unit_drug'=> $data_to_service['unit_drug'],
                                      'how_to_use_medicine'=> $data_to_service['how_to_use_medicine'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->employeetreatmentRepository->insertUpdate($data_to_service);
        }

        return $response;
    }


    public function updateData2($data_employee_treatment, $id){
        $this->employeetreatmentRepository->update2($data_employee_treatment, $id);
    }

    public function updateData3($data_general_physical_examination, $id){
        $this->employeetreatmentRepository->update3($data_general_physical_examination, $id);
    }

    public function updateData4($data_vital_signs, $id){
        $this->employeetreatmentRepository->update4($data_vital_signs, $id);
    }

    public function updateData5($data_to_service, $id, $id_general_diagnosis){
           
        if($id_general_diagnosis!=''){
          $response = $this->employeetreatmentRepository->update5($data_to_service, $id_general_diagnosis);
        }else {
            $data_to_service = [
                                  'employee_treat_id'=> $id,
                                  'diagnosis_id'=> $data_to_service['diagnosis_id'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->employeetreatmentRepository->insertUpdate1($data_to_service);
        }

        return $response;
    }


    public function deleteEmployeeTreatment($ids){
      $this->employeetreatmentRepository->deleteEmployeeTreatment($ids);          
    }
        
}
