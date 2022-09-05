<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StudentCurrentHealthHistoryService;
use Illuminate\Http\Request;

use Carbon\Carbon;

class StudentCurrentHealthHistoryController extends Controller
{
    protected $StudentCurrentHealthHistoryService;

  public function __construct(StudentCurrentHealthHistoryService $StudentCurrentHealthHistoryService){
    $this->StudentCurrentHealthHistoryService = $StudentCurrentHealthHistoryService;
  }

  public function getGeneralDiagnosisOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name,
      'created_at'=>$request->created_at
    ];
    return $this->StudentCurrentHealthHistoryService->getGeneralDiagnosisOptions($filters);
  }

  public function getStudentCurrentHealthHistoryOptions(Request $request){
    $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id,
      'name' => $request->name,
      'keyword'=>$request->keyword,
      'level' => $request->level,
      'kelas' => $request->kelas,
    ];
    return $this->StudentCurrentHealthHistoryService->getStudentCurrentHealthHistoryOptions($filters);
  }


  public function createStudentCurrentHealthHistory(Request $request){

    try{
      
      $data_current_health_history = [
        'name' => $request->name,
        'niy' => $request->niy,
        'level' => $request->level,
        'kelas' =>$request->kelas,
        'blood_group' => $request->blood_group,
        'blood_group_rhesus' => $request->blood_group_rhesus,
        'history_of_drug_allergy' => $request->history_of_drug_allergy,
        'covid19_illness_history' => $request->covid19_illness_history,
        'covid19_sick_date' => $request->covid19_sick_date,
        'covid19_vaccine_history' => $request->covid19_vaccine_history,
        'covid19_vaccine_description' => $request->covid19_vaccine_description,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
     $lastId = $this->StudentCurrentHealthHistoryService->createDataCurrentHistory($data_current_health_history, $request->id);

      $data_birth_time_data = [
        'weight' => $request->weight,
        'height' => $request->height,
        'head_circumference' => $request->head_circumference,
        'month' => $request->month,
        'birth_condition' => $request->birth_condition,
        'indication' => $request->indication,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->StudentCurrentHealthHistoryService->createStudentCurrentHealthHistory($data_birth_time_data, $request->id); 
      
      
      $dynamicFormVaccineCovid19 =  json_decode($request->dynamicFormVaccineCovid19, true);

      if (is_array($dynamicFormVaccineCovid19 ) || is_object($dynamicFormVaccineCovid19 )){

      foreach($dynamicFormVaccineCovid19 as $row){ 
      
      $vaccine_to= $row['vaccine_to'];
      $vaccine_date= $row['vaccine_date'];

      $data_covid19_vaccine_history = [
        'vaccine_to' =>  $vaccine_to,
        'vaccine_date' =>  $vaccine_date,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->StudentCurrentHealthHistoryService->createDynamicFormVaccineCovid19($data_covid19_vaccine_history); 

      
    }

  }




  $dynamicFormBasicImmunization =  json_decode($request->dynamicFormBasicImmunization, true);

  if (is_array($dynamicFormBasicImmunization ) || is_object($dynamicFormBasicImmunization )){
  
  foreach($dynamicFormBasicImmunization as $row){ 

      $type_of_immunization= $row['type_of_immunization'];
      $immunization_date= $row['immunization_date'];
      $value= $row['value'];

      $data_basic_immunization_history = [
        'type_of_immunization' => $type_of_immunization,
        'immunization_date' => $immunization_date,
        'value' => $value,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->StudentCurrentHealthHistoryService->createDynamicFormBasicImmunization($data_basic_immunization_history); 

      }

    }

      $dynamicFormHospitalizationHistory =  json_decode($request->dynamicFormHospitalizationHistory, true);
     

     if (is_array($dynamicFormHospitalizationHistory ) || is_object($dynamicFormHospitalizationHistory )){
  
  foreach($dynamicFormHospitalizationHistory as $row){ 
         

      $hospital_name= $row['hospital_name'];
      $date_treated= $row['date_treated'];
      $diagnosis= $row['diagnosis'];
      $other_diagnosis= $row['other_diagnosis'];

      $data_hospitalization_history = [
        'hospital_name' => $hospital_name,
        'date_treated' => $date_treated,
        'diagnosis' => $diagnosis,
        'other_diagnosis' => $other_diagnosis,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->StudentCurrentHealthHistoryService->createDynamicFormHospitalizationHistory($data_hospitalization_history); 

      }

      } 
     
     $dynamicFormComorbidities =  json_decode($request->dynamicFormComorbidities, true);

      if (is_array($dynamicFormComorbidities ) || is_object($dynamicFormComorbidities )){

      foreach($dynamicFormComorbidities as $row){ 

      $history_of_comorbidities= $row['history_of_comorbidities'];

      $data_history_of_comorbidities = [
        'history_of_comorbidities' =>  $history_of_comorbidities,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->StudentCurrentHealthHistoryService->createDynamicFormComorbidities($data_history_of_comorbidities); 

      }
    }

      $dynamicFormPastMedicalHistory =  json_decode($request->dynamicFormPastMedicalHistory, true);

      if (is_array($dynamicFormPastMedicalHistory ) || is_object($dynamicFormPastMedicalHistory )){

      foreach($dynamicFormPastMedicalHistory as $row){ 

      $past_medical_history= $row['past_medical_history'];

      $data_past_medical_history = [
        'past_medical_history' => $past_medical_history,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->StudentCurrentHealthHistoryService->createDynamicFormPastMedicalHistory($data_past_medical_history); 

      }
    }

      $dynamicFormFamilyDiseaseHistory =  json_decode($request->dynamicFormFamilyDiseaseHistory, true);

      if (is_array($dynamicFormFamilyDiseaseHistory ) || is_object($dynamicFormFamilyDiseaseHistory )){

      foreach($dynamicFormFamilyDiseaseHistory as $row){ 

      $family_history_of_illness= $row['family_history_of_illness'];

      $data_family_history_of_illness = [
        'family_history_of_illness' => $family_history_of_illness,
        'student_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->StudentCurrentHealthHistoryService->createDynamicFormFamilyDiseaseHistory($data_family_history_of_illness); 

      }
    }
      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create student current health history']);
    }

  }


  public function updateStudentCurrentHealthHistory(Request $request){

    try{
      
      $data_to_service = array();

      $dynamicFormVaccineCovid19 =  json_decode($request->dynamicFormVaccineCovid19, true);
          
            if (is_array($dynamicFormVaccineCovid19 ) || is_object($dynamicFormVaccineCovid19 )){


            foreach($dynamicFormVaccineCovid19 as $row){ 
  
            $data_to_service = [
                                  'vaccine_to'=> $row['vaccine_to'],
                                  'vaccine_date'=> $row['vaccine_date'],
                                  'updated_at' => Carbon::now()
                                ];

            if(!empty($row['id'])){
              $id_vaccine = $row['id'];
            }else{
             $id_vaccine = '';
            }
            
            $this->StudentCurrentHealthHistoryService->updateData($data_to_service, $request->id, $id_vaccine); 

            }
           

          }
      
      $dynamicFormBasicImmunization =  json_decode($request->dynamicFormBasicImmunization, true);
      
      if (is_array($dynamicFormBasicImmunization ) || is_object($dynamicFormBasicImmunization )){

      foreach($dynamicFormBasicImmunization as $row){ 

      $data_to_service = [
                                  'type_of_immunization'=> $row['type_of_immunization'],
                                  'immunization_date'=> $row['immunization_date'],
                                  'value'=> $row['value'],
                                  'updated_at' => Carbon::now()
                                ];

       if(!empty($row['id'])){
              $id_immunization = $row['id'];
            }else{
             $id_immunization = '';
            }

      $this->StudentCurrentHealthHistoryService->updateData2($data_to_service, $request->id, $id_immunization);

      }

    }

      $dynamicFormHospitalizationHistory =  json_decode($request->dynamicFormHospitalizationHistory, true);

          if (is_array($dynamicFormHospitalizationHistory ) || is_object($dynamicFormHospitalizationHistory ))
          {

              foreach($dynamicFormHospitalizationHistory as $row){ 

                  $data_to_service = [
                                      'hospital_name' => $row['hospital_name'],
                                      'date_treated' => $row['date_treated'],
                                      'diagnosis' => $row['diagnosis'],
                                      'other_diagnosis' => $row['other_diagnosis'],
                                      'updated_at' => Carbon::now()
                                      ];

                  if(!empty($row['id'])){
                      $id_hospital = $row['id'];
                    }else{
                    $id_hospital = '';
                    }

                  $this->StudentCurrentHealthHistoryService->updateData3($data_to_service, $request->id, $id_hospital);
              }
          }
    

      $dynamicFormComorbidities =  json_decode($request->dynamicFormComorbidities, true);

      if (is_array($dynamicFormComorbidities ) || is_object($dynamicFormComorbidities )){

      foreach($dynamicFormComorbidities as $row){ 

       $data_to_service = [
                            'history_of_comorbidities' => $row['history_of_comorbidities'],
                            'updated_at' => Carbon::now()
                          ];


        if(!empty($row['id'])){
                      $id_comorbidities = $row['id'];
                    }else{
                    $id_comorbidities = '';
          }
      
      $this->StudentCurrentHealthHistoryService->updateData4($data_to_service, $request->id, $id_comorbidities); 

      }
    }

    $dynamicFormPastMedicalHistory =  json_decode($request->dynamicFormPastMedicalHistory, true);

      if (is_array($dynamicFormPastMedicalHistory ) || is_object($dynamicFormPastMedicalHistory )){

      foreach($dynamicFormPastMedicalHistory as $row){ 

      $data_to_service = [
                            'past_medical_history' => $row['past_medical_history'],
                            'updated_at' => Carbon::now()
                          ];

      if(!empty($row['id'])){
                      $id_past = $row['id'];
                    }else{
                    $id_past = '';
          }
      
      $this->StudentCurrentHealthHistoryService->UpdateData5($data_to_service, $request->id, $id_past); 

      }
    }

     $dynamicFormFamilyDiseaseHistory =  json_decode($request->dynamicFormFamilyDiseaseHistory, true);

      if (is_array($dynamicFormFamilyDiseaseHistory ) || is_object($dynamicFormFamilyDiseaseHistory )){

      foreach($dynamicFormFamilyDiseaseHistory as $row){ 

      $data_to_service = [
                            'family_history_of_illness' => $row['family_history_of_illness'],
                            'updated_at' => Carbon::now()
                          ];

      if(!empty($row['id'])){
                      $id_family = $row['id'];
                    }else{
                    $id_family = '';
          }
      
      $this->StudentCurrentHealthHistoryService->UpdateData6($data_to_service, $request->id, $id_family); 

      }
    }

      $data_current_health_history = [
        'name' => $request->name,
        'niy' => $request->niy,
        'level' => $request->level,
        'kelas' =>$request->kelas,
        'blood_group' => $request->blood_group,
        'history_of_drug_allergy' => $request->history_of_drug_allergy,
        'covid19_illness_history' => $request->covid19_illness_history,
        'covid19_sick_date' => $request->covid19_sick_date,
        'updated_at' => Carbon::now()
      ];

      
     $this->StudentCurrentHealthHistoryService->updateData7($data_current_health_history, $request->id);

      $data_birth_time_data = [
        'weight' => $request->weight,
        'height' => $request->height,
        'head_circumference' => $request->head_circumference,
        'month' => $request->month,
        'birth_condition' => $request->birth_condition,
        'indication' => $request->indication,
        'updated_at' => Carbon::now()
      ];

      $this->StudentCurrentHealthHistoryService->updateData8($data_birth_time_data, $request->id);
      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update student current health history']);
    }

  }

  

  public function deleteStudentCurrentHealthHistory(Request $request){
    try{      
      $this->StudentCurrentHealthHistoryService->deleteStudentCurrentHealthHistory($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete student current health history']);
    }
  }

}
