<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EmployeeMCUService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmployeeMCUController extends Controller
{
    public $success = 200;
    public $unauth = 401;
    public $error = 500;
    public $conflict = 409;

    protected $EmployeeMCUService;

  public function __construct(EmployeeMCUService $EmployeeMCUService){
    $this->EmployeeMCUService = $EmployeeMCUService;
  }

  public function getEmployeeMCUOptions(Request $request){
    $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id,
      'name' => $request->name,
      'keyword'=>$request->keyword,
      'unit' => $request->unit,
      'inspection_date' => $request->inspection_date,
      'created_at' => $request->created_at
    ];
    return $this->EmployeeMCUService->getEmployeeMCUOptions($filters, $request->rowsPerPage);
  }

  public function createEmployeeMCU(Request $request){
    if ($request->hasFile('file')) {
        $file_extension = $request->file('file')->getClientOriginalExtension();
        $file           = $request->file('file')->storeAs('document',time().'.'.$file_extension );
    }else{
      $file = '';
    }
    try{
      $data_employee_mcu = [
      'name' => $request->name,
      'nik' => $request->nik,
      'unit' => $request->unit,
      'inspection_date' => $request->inspection_date,
      'blood_pressure' => $request->blood_pressure,
      'heart_rate' => $request->heart_rate,
      'breathing_ratio' => $request->breathing_ratio,
      'body_temperature' => $request->body_temperature,
      'sp02' => $request->sp02,
      'weight' => $request->weight,
      'height' => $request->height,
      'bmi_calculation_results' => $request->bmi_calculation_results,
      'bmi_diagnosis' => $request->bmi_diagnosis,
      'file' => $file,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $lastId = $this->EmployeeMCUService->createDataEmployeeMCU($data_employee_mcu);

      $dynamicForm =  json_decode($request->dynamicForm, true);

      foreach($dynamicForm as $row){ 

      $diagnosis_id = $row['diagnosis_id'];

      $data_general_diagnosis = [
      'diagnosis_id' =>$diagnosis_id,
      'employee_mcu_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->EmployeeMCUService->createGeneralDiagnosis($data_general_diagnosis);
    }     
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create employee mcu']);
    }

  }

  public function updateEmployeeMCU(Request $request){
     
    try{

     $data_to_service = array();

     $dynamicForm =  json_decode($request->dynamicForm, true);

      foreach($dynamicForm as $row){ 

      $data_to_service = [
      'diagnosis_id' => $row['diagnosis_id'],
      'updated_at' => Carbon::now()
      ];

      if(!empty($row['id'])){
              $id_diagnosis = $row['id'];
            }else{
             $id_diagnosis = '';
            }

      $this->EmployeeMCUService->updateGeneralDiagnosis($data_to_service, $request->id, $id_diagnosis);     

    }
     $data_employee_mcu = [
      'name' => $request->name,
      'nik' => $request->nik,
      'unit' => $request->unit,
      'inspection_date' => $request->inspection_date,
      'blood_pressure' => $request->blood_pressure,
      'heart_rate' => $request->heart_rate,
      'breathing_ratio' => $request->breathing_ratio,
      'body_temperature' => $request->body_temperature,
      'sp02' => $request->sp02,
      'weight' => $request->weight,
      'height' => $request->height,
      'bmi_calculation_results' => $request->bmi_calculation_results,
      'bmi_diagnosis' => $request->bmi_diagnosis,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      if ($request->hasFile('file')) {
        $file_extension = $request->file('file')->getClientOriginalExtension();
        $file           = $request->file('file')->storeAs('document',time().'.'.$file_extension );
        $data_employee_mcu['file'] = $file;
    }

      $this->EmployeeMCUService->updateDataEmployeeMCU($data_employee_mcu, $request->id);

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update employee mcu']);
    }

  }

  public function deleteEmployeeMCU(Request $request){
    try{      
      $this->EmployeeMCUService->deleteEmployeeMCU($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete employee mcu']);
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
