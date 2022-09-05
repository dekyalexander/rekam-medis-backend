<?php

namespace App\Services;
use App\Repositories\EmployeeCurrentHealthHistoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EmployeeCurrentHealthHistoryService{
    protected $employeecurrenthealthhistoryRepository;

    public function __construct(EmployeeCurrentHealthHistoryRepository $employeecurrenthealthhistoryRepository){
	    $this->employeecurrenthealthhistoryRepository = $employeecurrenthealthhistoryRepository;
    }

    public function getGeneralDiagnosisOptions($filters){
	    return $this->employeecurrenthealthhistoryRepository->getGeneralDiagnosisOptions($filters)->get();
    }

    public function getEmployeeCurrentHealthHistoryOptions($filters, $rowsPerPage=25){
	    return $this->employeecurrenthealthhistoryRepository->getEmployeeCurrentHealthHistoryOptions($filters)->paginate($rowsPerPage);
    }

    public function createDataEmployeeCurrentHealthHistory($data_current_health_history){
       return $this->employeecurrenthealthhistoryRepository->insert($data_current_health_history);
    }

    public function createDynamicFormVaccineCovid19($data_covid19_vaccine_history){
        $this->employeecurrenthealthhistoryRepository->insert2($data_covid19_vaccine_history);
    }

    public function createDynamicFormHospitalizationHistory($data_hospitalization_history){
        $this->employeecurrenthealthhistoryRepository->insert3($data_hospitalization_history);
    }

    public function createDynamicFormComorbidities($data_history_of_comorbidities){
        $this->employeecurrenthealthhistoryRepository->insert4($data_history_of_comorbidities);
    }

    public function createDynamicFormPastMedicalHistory($data_past_medical_history){
        $this->employeecurrenthealthhistoryRepository->insert5($data_past_medical_history);
    }

    public function createDynamicFormFamilyDiseaseHistory($data_family_history_of_illness){
        $this->employeecurrenthealthhistoryRepository->insert6($data_family_history_of_illness);
    }

    public function updateData($data_to_service, $id, $id_vaccine){
           
        if($id_vaccine!=''){
          $response = $this->employeecurrenthealthhistoryRepository->updateData($data_to_service, $id_vaccine);
        }else {
            $data_to_service = [
                                  'employee_health_id'=> $id,
                                  'vaccine_to'=> $data_to_service['vaccine_to'],
                                  'vaccine_date'=> $data_to_service['vaccine_date'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->employeecurrenthealthhistoryRepository->insertUpdate1($data_to_service);
        }

        return $response;
    }

    public function updateData2($data_to_service, $id, $id_hospital){

        if($id_hospital!=''){
          $response = $this->employeecurrenthealthhistoryRepository->updateData2($data_to_service, $id_hospital);
        }else {
          $data_to_service = [
                                      'employee_health_id'=> $id,
                                      'hospital_name' => $data_to_service['hospital_name'],
                                      'date_treated' => $data_to_service['date_treated'],
                                      'diagnosis' => $data_to_service['diagnosis'],
                                      'other_diagnosis' => $data_to_service['other_diagnosis'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->employeecurrenthealthhistoryRepository->insertUpdate2($data_to_service);
        }

        return $response;
    }

    public function updateData3($data_to_service, $id, $id_comorbidities){

        if($id_comorbidities!=''){
          $response = $this->employeecurrenthealthhistoryRepository->updateData3($data_to_service, $id_comorbidities);
        }else {
          $data_to_service = [
                                      'employee_health_id'=> $id,
                                      'history_of_comorbidities' => $data_to_service['history_of_comorbidities'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->employeecurrenthealthhistoryRepository->insertUpdate3($data_to_service);
        }

        return $response;
    }

    public function updateData4($data_to_service, $id, $id_past){

        if($id_past!=''){
          $response = $this->employeecurrenthealthhistoryRepository->updateData4($data_to_service, $id_past);
        }else {
          $data_to_service = [
                                      'employee_health_id'=> $id,
                                      'past_medical_history' => $data_to_service['past_medical_history'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->employeecurrenthealthhistoryRepository->insertUpdate4($data_to_service);
        }

        return $response;
    }

    public function updateData5($data_to_service, $id, $id_family){

        if($id_family!=''){
          $response = $this->employeecurrenthealthhistoryRepository->updateData5($data_to_service, $id_family);
        }else {
          $data_to_service = [
                                      'employee_health_id'=> $id,
                                      'family_history_of_illness' => $data_to_service['family_history_of_illness'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->employeecurrenthealthhistoryRepository->insertUpdate5($data_to_service);
        }

        return $response;
    }

     public function updateData6($data, $id){

        $this->employeecurrenthealthhistoryRepository->updateData6($data, $id);

    }


    public function deleteEmployeeCurrentHealthHistory($ids){
       return $this->employeecurrenthealthhistoryRepository->deleteEmployeeCurrentHealthHistory($ids);
    }
        
}
