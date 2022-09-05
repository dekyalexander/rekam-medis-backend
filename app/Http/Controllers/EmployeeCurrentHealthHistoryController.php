<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EmployeeCurrentHealthHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// use Validator;
use Carbon\Carbon;

class EmployeeCurrentHealthHistoryController extends Controller
{
    public $success = 200;
    public $unauth = 401;
    public $error = 500;
    public $conflict = 409;

    protected $EmployeeCurrentHealthHistoryService;

  public function __construct(EmployeeCurrentHealthHistoryService $EmployeeCurrentHealthHistoryService){
    $this->EmployeeCurrentHealthHistoryService = $EmployeeCurrentHealthHistoryService;
  }

  public function getGeneralDiagnosisOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name,
      'created_at'=>$request->created_at
    ];
    return $this->EmployeeCurrentHealthHistoryService->getGeneralDiagnosisOptions($filters);
  }


  public function getEmployeeCurrentHealthHistoryOptions(Request $request){
    $filters=[
        // 'unit_id' => $request->unit_id,
        'roles_id' => $request->roles_id,
        'user_id' => $request->user_id,
        'name' => $request->name,
        'keyword'=>$request->keyword,
        'unit' => $request->unit
    ];
    return $this->EmployeeCurrentHealthHistoryService->getEmployeeCurrentHealthHistoryOptions($filters);
  }

  

  public function createEmployeeCurrentHealthHistory(Request $request){

    // $validator = Validator::make($request->all(),[ 
    //     'file' => 'required|mimes:doc,docx,pdf,jpg,png|max:1024',
    //   ]);   
 
    // if($validator->fails()) {          
            
    //   return response()->json(['error'=>$validator->errors()], 401);                        
    // }  
    
    if ($request->hasFile('file')) {
        $file_extension = $request->file('file')->getClientOriginalExtension();
        $file           = $request->file('file')->storeAs('document',time().'.'.$file_extension );
        // $url            = "http://127.0.0.1:8001/storage/".$file;
    }else{
      $file = '';
    }
    
    try{
      
      $data_current_health_history = [
        'name' => $request->name,
        'nik' => $request->nik,
        'unit' => $request->unit,
        'blood_group' => $request->blood_group,
        'blood_group_rhesus' => $request->blood_group_rhesus,
        'basic_immunization' => $request->basic_immunization,
        'history_of_drug_allergy' => $request->history_of_drug_allergy,
        'covid19_illness_history' => $request->covid19_illness_history,
        'covid19_sick_date' => $request->covid19_sick_date,
        'covid19_vaccine_history' => $request->covid19_vaccine_history,
        'covid19_vaccine_description' => $request->covid19_vaccine_description,
        'file' => $file,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $lastId = $this->EmployeeCurrentHealthHistoryService->createDataEmployeeCurrentHealthHistory($data_current_health_history);
      
      
      $dynamicFormVaccineCovid19 =  json_decode($request->dynamicFormVaccineCovid19, true);

      if (is_array($dynamicFormVaccineCovid19 ) || is_object($dynamicFormVaccineCovid19 )){


      foreach($dynamicFormVaccineCovid19 as $row){ 

      $vaccine_to= $row['vaccine_to'];
      $vaccine_date= $row['vaccine_date'];

      $data_covid19_vaccine_history = [
        'vaccine_to' => $vaccine_to,
        'vaccine_date' => $vaccine_date,
        'employee_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->EmployeeCurrentHealthHistoryService->createDynamicFormVaccineCovid19($data_covid19_vaccine_history); 

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
        'employee_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->EmployeeCurrentHealthHistoryService->createDynamicFormHospitalizationHistory($data_hospitalization_history); 

      }


    }

      $dynamicFormComorbidities =  json_decode($request->dynamicFormComorbidities, true);

      if (is_array($dynamicFormComorbidities ) || is_object($dynamicFormComorbidities )){

      foreach($dynamicFormComorbidities as $row){ 

      $history_of_comorbidities= $row['history_of_comorbidities'];

      $data_history_of_comorbidities = [
        'history_of_comorbidities' =>  $history_of_comorbidities,
        'employee_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->EmployeeCurrentHealthHistoryService->createDynamicFormComorbidities($data_history_of_comorbidities); 

      }
    }

      $dynamicFormPastMedicalHistory =  json_decode($request->dynamicFormPastMedicalHistory, true);

      if (is_array($dynamicFormPastMedicalHistory ) || is_object($dynamicFormPastMedicalHistory )){

      foreach($dynamicFormPastMedicalHistory as $row){ 

      $past_medical_history	= $row['past_medical_history'];

      $data_past_medical_history = [
        'past_medical_history' => $past_medical_history,
        'employee_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->EmployeeCurrentHealthHistoryService->createDynamicFormPastMedicalHistory($data_past_medical_history); 

      }
    }

      $dynamicFormFamilyDiseaseHistory =  json_decode($request->dynamicFormFamilyDiseaseHistory, true);

      if (is_array($dynamicFormFamilyDiseaseHistory ) || is_object($dynamicFormFamilyDiseaseHistory )){

      foreach($dynamicFormFamilyDiseaseHistory as $row){ 

      $family_history_of_illness= $row['family_history_of_illness'];

      $data_family_history_of_illness = [
        'family_history_of_illness' => $family_history_of_illness,
        'employee_health_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      
      $this->EmployeeCurrentHealthHistoryService->createDynamicFormFamilyDiseaseHistory($data_family_history_of_illness); 

      }
    }
      
      return response(['message'=>'success']);
      

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create employee current health history']);
    }

  }

  public function updateEmployeeCurrentHealthHistory(Request $request){
   
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
            
            $this->EmployeeCurrentHealthHistoryService->updateData($data_to_service, $request->id, $id_vaccine); 

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

                  $this->EmployeeCurrentHealthHistoryService->updateData2($data_to_service, $request->id, $id_hospital);
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
      
      $this->EmployeeCurrentHealthHistoryService->updateData3($data_to_service, $request->id, $id_comorbidities); 

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
      
      $this->EmployeeCurrentHealthHistoryService->UpdateData4($data_to_service, $request->id, $id_past); 

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
      
      $this->EmployeeCurrentHealthHistoryService->UpdateData5($data_to_service, $request->id, $id_family); 

      }
    }

    $data = [
        'name' => $request->name,
        'nik' => $request->nik,
        'unit' => $request->unit,
        'blood_group' => $request->blood_group,
        'blood_group_rhesus' => $request->blood_group_rhesus,
        'basic_immunization' => $request->basic_immunization,
        'history_of_drug_allergy' => $request->history_of_drug_allergy,
        'covid19_illness_history' => $request->covid19_illness_history,
        'covid19_sick_date' => $request->covid19_sick_date,
        'covid19_vaccine_history' => $request->covid19_vaccine_history,
        'covid19_vaccine_description' => $request->covid19_vaccine_description,
        'updated_at' => Carbon::now()
      ];

      if ($request->hasFile('file')) {
        $file_extension = $request->file('file')->getClientOriginalExtension();
        $file           = $request->file('file')->storeAs('document',time().'.'.$file_extension );
        $data['file'] = $file;
    }

      $this->EmployeeCurrentHealthHistoryService->UpdateData6($data, $request->id); 

      return response(['message'=>'success']);


        }catch(\Exception $e){
          return response(['error'=>$e->getMessage(), 'message'=>'failed update employee current health history']);
       }


  }


  public function deleteEmployeeCurrentHealthHistory(Request $request){
    try{      
      $this->EmployeeCurrentHealthHistoryService->deleteEmployeeCurrentHealthHistory($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete employee current health history']);
    }
  }

  public function downloadDocument(Request $request){
      $paramFile = $request->namaFile;
      try{
          return Storage::disk('public')->download($paramFile);
      }catch(\Exception $e){
          return $result = [
          'status' => $this->error,
          'error' => $e->getMessage(),
          'message' => 'Download data fail'
          ];        
      }
    }


}
