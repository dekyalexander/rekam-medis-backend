<?php

namespace App\Services;
use App\Repositories\StudentCurrentHealthHistoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class StudentCurrentHealthHistoryService{
    protected $studentcurrenthealthhistoryRepository;

    public function __construct(StudentCurrentHealthHistoryRepository $studentcurrenthealthhistoryRepository){
	    $this->studentcurrenthealthhistoryRepository = $studentcurrenthealthhistoryRepository;
    }

    public function getGeneralDiagnosisOptions($filters){
	    return $this->studentcurrenthealthhistoryRepository->getGeneralDiagnosisOptions($filters)->get();
    }

    public function getStudentCurrentHealthHistoryOptions($filters, $rowsPerPage=25){
	    return $this->studentcurrenthealthhistoryRepository->getStudentCurrentHealthHistoryOptions($filters)->paginate($rowsPerPage);
    }

    public function createDataCurrentHistory($data_current_health_history){
       return $this->studentcurrenthealthhistoryRepository->insert2($data_current_health_history);
    }

    public function createStudentCurrentHealthHistory($data_birth_time_data){
        $this->studentcurrenthealthhistoryRepository->insert($data_birth_time_data);
    }


    public function createDynamicFormVaccineCovid19($data_covid19_vaccine_history){
        $this->studentcurrenthealthhistoryRepository->insert8($data_covid19_vaccine_history);
    }


    public function createDynamicFormHospitalizationHistory($data_hospitalization_history){
        $this->studentcurrenthealthhistoryRepository->insert3($data_hospitalization_history);
    }

    public function createDynamicFormComorbidities($data_history_of_comorbidities){
        $this->studentcurrenthealthhistoryRepository->insert4($data_history_of_comorbidities);
    }

    public function createDynamicFormPastMedicalHistory($data_past_medical_history){
        $this->studentcurrenthealthhistoryRepository->insert5($data_past_medical_history);
    }

    public function createDynamicFormFamilyDiseaseHistory($data_family_history_of_illness){
        $this->studentcurrenthealthhistoryRepository->insert6($data_family_history_of_illness);
    }

    public function createDynamicFormBasicImmunization($data_basic_immunization_history){
        $this->studentcurrenthealthhistoryRepository->insert7($data_basic_immunization_history);
    }

    public function updateData($data_to_service, $id, $id_vaccine){
           
        if($id_vaccine!=''){
          $response = $this->studentcurrenthealthhistoryRepository->updateData($data_to_service, $id_vaccine);
        }else {
            $data_to_service = [
                                  'student_health_id'=> $id,
                                  'vaccine_to'=> $data_to_service['vaccine_to'],
                                  'vaccine_date'=> $data_to_service['vaccine_date'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];
            var_dump($id);

          $response = $this->studentcurrenthealthhistoryRepository->insertUpdate1($data_to_service);
        }

        return $response;
    }

    public function updateData2($data_to_service, $id, $id_immunization){
           
        if($id_immunization!=''){
          $response = $this->studentcurrenthealthhistoryRepository->updateData2($data_to_service, $id_immunization);
        }else {
            $data_to_service = [
                                  'student_health_id'=> $id,
                                  'type_of_immunization'=> $data_to_service['type_of_immunization'],
                                  'immunization_date'=> $data_to_service['immunization_date'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->studentcurrenthealthhistoryRepository->insertUpdate2($data_to_service);
        }

        return $response;
    }

    public function updateData3($data_to_service, $id, $id_hospital){

        if($id_hospital!=''){
          $response = $this->studentcurrenthealthhistoryRepository->updateData3($data_to_service, $id_hospital);
        }else {
          $data_to_service = [
                                      'student_health_id'=> $id,
                                      'hospital_name' => $data_to_service['hospital_name'],
                                      'date_treated' => $data_to_service['date_treated'],
                                      'diagnosis' => $data_to_service['diagnosis'],
                                      'other_diagnosis' => $data_to_service['other_diagnosis'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->studentcurrenthealthhistoryRepository->insertUpdate3($data_to_service);
        }

        return $response;
    }

    public function updateData4($data_to_service, $id, $id_comorbidities){

        if($id_comorbidities!=''){
          $response = $this->studentcurrenthealthhistoryRepository->updateData4($data_to_service, $id_comorbidities);
        }else {
          $data_to_service = [
                                      'student_health_id'=> $id,
                                      'history_of_comorbidities' => $data_to_service['history_of_comorbidities'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->studentcurrenthealthhistoryRepository->insertUpdate4($data_to_service);
        }

        return $response;
    }

    public function updateData5($data_to_service, $id, $id_past){

        if($id_past!=''){
          $response = $this->studentcurrenthealthhistoryRepository->updateData5($data_to_service, $id_past);
        }else {
          $data_to_service = [
                                      'student_health_id'=> $id,
                                      'past_medical_history' => $data_to_service['past_medical_history'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->studentcurrenthealthhistoryRepository->insertUpdate5($data_to_service);
        }

        return $response;
    }

    public function updateData6($data_to_service, $id, $id_family){

        if($id_family!=''){
          $response = $this->studentcurrenthealthhistoryRepository->updateData6($data_to_service, $id_family);
        }else {
          $data_to_service = [
                                      'student_health_id'=> $id,
                                      'family_history_of_illness' => $data_to_service['family_history_of_illness'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->studentcurrenthealthhistoryRepository->insertUpdate6($data_to_service);
        }

        return $response;
    }

     public function updateData7($data_current_health_history, $id){

        $this->studentcurrenthealthhistoryRepository->updateData7($data_current_health_history, $id);

    }

     public function updateData8($data_birth_time_data, $id){

        $this->studentcurrenthealthhistoryRepository->updateData8($data_birth_time_data, $id);

    }

    public function deleteStudentCurrentHealthHistory($ids){
       return $this->studentcurrenthealthhistoryRepository->deleteStudentCurrentHealthHistory($ids);
    }
        
}
