<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StudentMCUService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentMCUController extends Controller
{
    protected $StudentMCUService;

  public function __construct(StudentMCUService $StudentMCUService){
    $this->StudentMCUService = $StudentMCUService;
  }

  public function getEyeVisusOptions(Request $request){
    $filters=[
      'od'=>$request->od,
      'os'=>$request->os,
      'created_at'=>$request->created_at
    ];
    return $this->StudentMCUService->getEyeVisusOptions($filters);
  }

  public function getBMIDiagnosisOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name,
      'created_at'=>$request->created_at
    ];
    return $this->StudentMCUService->getBMIDiagnosisOptions($filters);
  }

  public function getMCUDiagnosisOptions(Request $request){
    $filters=[
      'diagnosis_kode'=>$request->diagnosis_kode,
      'diagnosis_name'=>$request->diagnosis_name,
      'created_at'=>$request->created_at
    ];
    return $this->StudentMCUService->getMCUDiagnosisOptions($filters);
  }

  public function geteyeDiagnosisOptions(Request $request){
    $filters=[
      'diagnosis_kode'=>$request->diagnosis_kode,
      'diagnosis_name'=>$request->diagnosis_name,
      'created_at'=>$request->created_at
    ];
    return $this->StudentMCUService->geteyeDiagnosisOptions($filters);
  }

  public function getStudentMCUOptions(Request $request){
    $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id,
      'name' => $request->name,
      'keyword'=>$request->keyword,
      'level' => $request->level,
      'kelas' => $request->kelas,
      'inspection_date' => $request->inspection_date,
      'created_at' => $request->created_at
    ];
    return $this->StudentMCUService->getStudentMCUOptions($filters, $request->rowsPerPage);
  }

  public function createStudentMCU(Request $request){
    try{
      $data_student_mcu = [
        'name' => $request->name,
        'niy' => $request->niy,
        'level' => $request->level,
        'kelas' => $request->kelas,
        'school_year' => $request->school_year,
        'inspection_date' => $request->inspection_date,
        'od_eyes' => $request->od_eyes,
        'os_eyes' => $request->os_eyes,
        'color_blind' => $request->color_blind,
        'blood_pressure' => $request->blood_pressure,
        'pulse' => $request->pulse,
        'respiration' => $request->respiration,
        'temperature' => $request->temperature,
        'dental_occlusion' => $request->dental_occlusion,
        'tooth_gap' => $request->tooth_gap,
        'crowding_teeth' => $request->crowding_teeth,
        'dental_debris' => $request->dental_debris,
        'tartar' => $request->tartar,
        'tooth_abscess' => $request->tooth_abscess,
        'tongue' => $request->tongue,
        'other' => $request->other,
        'suggestion' => $request->suggestion,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $lastId = $this->StudentMCUService->createDataStudentMCU($data_student_mcu);

      $data_examination = [
        'weight' => $request->weight,
        'height' => $request->height,
        'bmi_calculation_results' => $request->bmi_calculation_results,
        'bmi_diagnosis' => $request->bmi_diagnosis,
        'gender' => $request->gender,
        'age' => $request->age,
        'lk' => $request->lk,
        'lila' => $request->lila,
        'conclusion_lk' => $request->conclusion_lk,
        'conclusion_lila' => $request->conclusion_lila,
        'student_mcu_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
  
      $this->StudentMCUService->createStudentMCU($data_examination);

      $dynamicFormGeneralDiagnosis =  json_decode($request->dynamicFormGeneralDiagnosis, true);

      if (is_array($dynamicFormGeneralDiagnosis ) || is_object($dynamicFormGeneralDiagnosis )){

      foreach($dynamicFormGeneralDiagnosis as $row){ 

      $diagnosis_general_id = $row['diagnosis_general_id'];

      $data_general_diagnosis = [
      'diagnosis_general_id' =>$diagnosis_general_id,
      'student_mcu_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->StudentMCUService->createGeneralDiagnosis($data_general_diagnosis);
    }
  }
  
  $dynamicFormEyeDiagnosis =  json_decode($request->dynamicFormEyeDiagnosis, true);

      if (is_array($dynamicFormEyeDiagnosis ) || is_object($dynamicFormEyeDiagnosis )){

      foreach($dynamicFormEyeDiagnosis as $row){ 

      $diagnosis_eye_id = $row['diagnosis_eye_id'];

      $data_general_diagnosis = [
      'diagnosis_eye_id' =>$diagnosis_eye_id,
      'student_mcu_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->StudentMCUService->createEyeDiagnosis($data_general_diagnosis);
    }
  } 
  
  $dynamicFormDentalAndOralDiagnosis =  json_decode($request->dynamicFormDentalAndOralDiagnosis, true);

      if (is_array($dynamicFormDentalAndOralDiagnosis ) || is_object($dynamicFormDentalAndOralDiagnosis )){

      foreach($dynamicFormDentalAndOralDiagnosis as $row){ 

      $diagnosis_dental_id = $row['diagnosis_dental_id'];

      $data_general_diagnosis = [
      'diagnosis_dental_id' =>$diagnosis_dental_id,
      'student_mcu_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->StudentMCUService->createDentalAndOralDiagnosis($data_general_diagnosis);
    }
  } 
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create student mcu']);
    }

  }

  public function updateStudentMCU(Request $request){
    try{

      $data_to_service = array();

      $dynamicFormGeneralDiagnosis =  json_decode($request->dynamicFormGeneralDiagnosis, true);
          
            if (is_array($dynamicFormGeneralDiagnosis ) || is_object($dynamicFormGeneralDiagnosis )){


            foreach($dynamicFormGeneralDiagnosis as $row){ 
  
            $data_to_service = [
                                  'diagnosis_general_id'=> $row['diagnosis_general_id'],
                                  'updated_at' => Carbon::now()
                                ];

            if(!empty($row['id'])){
              $id_general_diagnosis = $row['id'];
            }else{
             $id_general_diagnosis = '';
            }
            
            $this->StudentMCUService->updateData3($data_to_service, $request->id, $id_general_diagnosis); 

            }
           

          }

           $dynamicFormEyeDiagnosis =  json_decode($request->dynamicFormEyeDiagnosis, true);
          
            if (is_array($dynamicFormEyeDiagnosis ) || is_object($dynamicFormEyeDiagnosis )){


            foreach($dynamicFormEyeDiagnosis as $row){ 
  
            $data_to_service = [
                                  'diagnosis_eye_id'=> $row['diagnosis_eye_id'],
                                  'updated_at' => Carbon::now()
                                ];

            if(!empty($row['id'])){
              $id_eye_diagnosis = $row['id'];
            }else{
             $id_eye_diagnosis = '';
            }
            
            $this->StudentMCUService->updateData4($data_to_service, $request->id,  $id_eye_diagnosis); 

            }
           

          }

          $dynamicFormDentalAndOralDiagnosis =  json_decode($request->dynamicFormDentalAndOralDiagnosis , true);
          
            if (is_array($dynamicFormDentalAndOralDiagnosis ) || is_object($dynamicFormDentalAndOralDiagnosis  )){


            foreach($dynamicFormDentalAndOralDiagnosis as $row){ 
  
            $data_to_service = [
                                  'diagnosis_dental_id'=> $row['diagnosis_dental_id'],
                                  'updated_at' => Carbon::now()
                                ];

            if(!empty($row['id'])){
              $id_dental_and_oral_diagnosis = $row['id'];
            }else{
             $id_dental_and_oral_diagnosis = '';
            }
            
            $this->StudentMCUService->updateData5($data_to_service, $request->id, $id_dental_and_oral_diagnosis); 

            }
           

          }
      
      $data_examination = [
        'weight' => $request->weight,
        'height' => $request->height,
        'bmi_calculation_results' => $request->bmi_calculation_results,
        'bmi_diagnosis' => $request->bmi_diagnosis,
        'gender' => $request->gender,
        'age' => $request->age,
        'lk' => $request->lk,
        'lila' => $request->lila,
        'conclusion_lk' => $request->conclusion_lk,
        'conclusion_lila' => $request->conclusion_lila,
        'updated_at' => Carbon::now()
      ];
  
      $this->StudentMCUService->updateData($data_examination, $request->id);
      
      $data_student_mcu = [
        'name' => $request->name,
        'niy' => $request->niy,
        'level' => $request->level,
        'kelas' => $request->kelas,
        'school_year' => $request->school_year,
        'inspection_date' => $request->inspection_date,
        'od_eyes' => $request->od_eyes,
        'os_eyes' => $request->os_eyes,
        'color_blind' => $request->color_blind,
        'blood_pressure' => $request->blood_pressure,
        'pulse' => $request->pulse,
        'respiration' => $request->respiration,
        'temperature' => $request->temperature,
        'dental_occlusion' => $request->dental_occlusion,
        'tooth_gap' => $request->tooth_gap,
        'crowding_teeth' => $request->crowding_teeth,
        'dental_debris' => $request->dental_debris,
        'tartar' => $request->tartar,
        'tooth_abscess' => $request->tooth_abscess,
        'tongue' => $request->tongue,
        'other' => $request->other,
        'suggestion' => $request->suggestion,
        'updated_at' => Carbon::now()
      ];

      $this->StudentMCUService->updateData2($data_student_mcu, $request->id);

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update student mcu']);
    }

  }


  public function deleteStudentMCU(Request $request){
    try{      
      $this->StudentMCUService->deleteStudentMCU($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete student mcu']);
    }
  }


}
