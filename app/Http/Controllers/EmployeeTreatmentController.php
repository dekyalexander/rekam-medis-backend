<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EmployeeTreatmentService;
use App\Services\DrugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use Validator;
use Carbon\Carbon;

class EmployeeTreatmentController extends Controller
{
    public $success = 200;
    public $unauth = 401;
    public $error = 500;
    public $conflict = 409;

    protected $EmployeeTreatmentService;

  public function __construct(EmployeeTreatmentService $EmployeeTreatmentService, DrugService $DrugService){
    $this->EmployeeTreatmentService = $EmployeeTreatmentService;
    $this->DrugService = $DrugService;
  }

  public function getEmployeeTreatmentOptions(Request $request){
    $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id,
      'name' => $request->name,
      'keyword'=>$request->keyword,
      'unit' => $request->unit,
      'inspection_date' => $request->inspection_date,
      'created_at' => $request->created_at
    ];
    return $this->EmployeeTreatmentService->getEmployeeTreatmentOptions($filters);
  }

  public function createEmployeeTreatment(Request $request){

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
      $data_employee_treatment = [
      'name' => $request->name,
      'nik' => $request->nik,
      'unit' => $request->unit,
      'inspection_date' => $request->inspection_date,
      'anamnesa' => $request->anamnesa,
      'head' => $request->head,
      'neck' => $request->neck,
      'eye' => $request->eye,
      'nose' => $request->nose,
      'tongue' => $request->tongue,
      'tooth' => $request->tooth,
      'gum' => $request->gum,
      'throat' => $request->throat,
      'tonsils' => $request->tonsils,
      'ear' => $request->ear,
      'lymph_nodes_and_neck' => $request->lymph_nodes_and_neck,
      'heart' => $request->heart,
      'lungs' => $request->lungs,
      'epigastrium' => $request->epigastrium,
      'hearts' => $request->hearts,
      'spleen' => $request->spleen,
      'intestines' => $request->intestines,
      'hand' => $request->hand,
      'foot' => $request->foot,
      'skin' => $request->skin,
      'description' => $request->description,
      'file' => $file,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $lastId = $this->EmployeeTreatmentService->createDataEmployeeTreatment($data_employee_treatment);

      $data_general_physical_examination = [
        'awareness' => $request->awareness,
        'distress_sign' => $request->distress_sign,
        'anxiety_sign' => $request->anxiety_sign,
        'sign_of_pain' => $request->sign_of_pain,
        'voice' => $request->voice,
        'employee_treat_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->EmployeeTreatmentService->createGeneralPhysicalExamination($data_general_physical_examination);

      $data_vital_signs = [
      'blood_pressure' => $request->blood_pressure,
      'heart_rate' => $request->heart_rate,
      'breathing_ratio' => $request->breathing_ratio,
      'body_temperature' => $request->body_temperature,
      'sp02' => $request->sp02,
      'employee_treat_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];
      
      $this->EmployeeTreatmentService->createVitalSigns($data_vital_signs);

      $dynamicFormGeneralDiagnosis =  json_decode($request->dynamicFormGeneralDiagnosis, true);

      if (is_array($dynamicFormGeneralDiagnosis ) || is_object($dynamicFormGeneralDiagnosis )){

      foreach($dynamicFormGeneralDiagnosis as $row){ 

      $diagnosis_id = $row['diagnosis_id'];

      $data_general_diagnosis = [
      'diagnosis_id' =>$diagnosis_id,
      'employee_treat_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->EmployeeTreatmentService->createGeneralDiagnosis($data_general_diagnosis);
    }
  }

      $dynamicForm =  json_decode($request->dynamicForm, true);

      if (is_array($dynamicForm) || is_object($dynamicForm )){

      foreach($dynamicForm as $row){ 

       // Object Pengurangan Jumlah Stok Dan Jumlah Ambil Obat
        
      $qty_update = $row['qty'] - $row['amount_medicine'];

      // Ambil Id Obat Distribusi Dari Frontend

      $drug_distribution_id = $row['drug_distribution_id'];

      $location_id= $row['location_id'];
      $drug_id= $row['drug_id'];
      $amount_medicine= $row['amount_medicine'];
      $unit_drug= $row['unit_drug'];
      $how_to_use_medicine= $row['how_to_use_medicine'];

      // Objek Jumlah Stok Yang Dikirim Atau Disimpan
      $qty = $qty_update;
      $date_expired= $row['date_expired'];
      $description= $row['description'];
        
      $data_medical_prescription = [
      'location_id' => $location_id,
      'drug_id' => $drug_id,
      'amount_medicine' => $amount_medicine,
      'unit_drug' => $unit_drug,
      'how_to_use_medicine' => $how_to_use_medicine,
      'employee_treat_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->EmployeeTreatmentService->createMedicalPrescription($data_medical_prescription);

      // Update Jumlah Stok Yang Di Ambil Dari Obat Distribusi

      $data_drug_distribution = [
        'qty' => $qty_update,
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->updateDrugDistributionSettings($data_drug_distribution,  $drug_distribution_id);

      // Simpan Transaksi Jumlah Obat Yang Sudah Diambil Dari Obat Distribusi

      $transactions = [
      'location_id' => $location_id,
      'drug_id' => $drug_id,
      'date_expired' => $date_expired,
      'qty_take' => $amount_medicine,
      'leftover_qty' => $qty,
      'description' => $description,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];
      
      $this->EmployeeTreatmentService->createTransactions($transactions);
    }
  }     
      return response(['message'=>'success', "file" => $file]);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create employee treatment']);
    }

  }


  public function updateEmployeeTreatment(Request $request){

    try{
      
      $data_to_service = array();

       $dynamicFormGeneralDiagnosis =  json_decode($request->dynamicFormGeneralDiagnosis, true);
          
            if (is_array($dynamicFormGeneralDiagnosis ) || is_object($dynamicFormGeneralDiagnosis )){


            foreach($dynamicFormGeneralDiagnosis as $row){ 
  
            $data_to_service = [
                                  'diagnosis_id'=> $row['diagnosis_id'],
                                  'updated_at' => Carbon::now()
                                ];

            if(!empty($row['id'])){
              $id_general_diagnosis = $row['id'];
            }else{
             $id_general_diagnosis = '';
            }
            
            $this->EmployeeTreatmentService->updateData5($data_to_service, $request->id, $id_general_diagnosis); 

            }
           

          }


      $dynamicForm =  json_decode($request->dynamicForm, true);

      if (is_array($dynamicForm ) || is_object($dynamicForm )){

      foreach($dynamicForm as $row){ 

     $data_to_service = [
                                  'location_id'=> $row['location_id'],
                                  'drug_id'=> $row['drug_id'],
                                  'amount_medicine'=> $row['amount_medicine'],
                                  'unit_drug'=> $row['unit_drug'],
                                  'how_to_use_medicine'=> $row['how_to_use_medicine'],
                                  'updated_at' => Carbon::now()
                                ];

      // var_dump($location_drug);

      if(!empty($row['id'])){
              $id_medical = $row['id'];
            }else{
             $id_medical = '';
            }

      $this->EmployeeTreatmentService->UpdateData($data_to_service, $request->id, $id_medical);

          }
        }

      

    


      $data_general_physical_examination = [
        'awareness' => $request->awareness,
        'distress_sign' => $request->distress_sign,
        'anxiety_sign' => $request->anxiety_sign,
        'sign_of_pain' => $request->sign_of_pain,
        'voice' => $request->voice,
        'updated_at' => Carbon::now()
      ];

      $this->EmployeeTreatmentService->UpdateData3($data_general_physical_examination, $request->id);

      $data_vital_signs = [
      'blood_pressure' => $request->blood_pressure,
      'heart_rate' => $request->heart_rate,
      'breathing_ratio' => $request->breathing_ratio,
      'body_temperature' => $request->body_temperature,
      'sp02' => $request->sp02,
      'updated_at' => Carbon::now()
      ];
      
      $this->EmployeeTreatmentService->UpdateData4($data_vital_signs, $request->id);

      $data_employee_treatment = [
      'name' => $request->name,
      'nik' => $request->nik,
      'unit' => $request->unit,
      'inspection_date' => $request->inspection_date,
      'anamnesa' => $request->anamnesa,
      'head' => $request->head,
      'neck' => $request->neck,
      'eye' => $request->eye,
      'nose' => $request->nose,
      'tongue' => $request->tongue,
      'tooth' => $request->tooth,
      'gum' => $request->gum,
      'throat' => $request->throat,
      'tonsils' => $request->tonsils,
      'ear' => $request->ear,
      'lymph_nodes_and_neck' => $request->lymph_nodes_and_neck,
      'heart' => $request->heart,
      'lungs' => $request->lungs,
      'epigastrium' => $request->epigastrium,
      'hearts' => $request->hearts,
      'spleen' => $request->spleen,
      'intestines' => $request->intestines,
      'hand' => $request->hand,
      'foot' => $request->foot,
      'skin' => $request->skin,
      'description' => $request->description,
      'updated_at' => Carbon::now()
      ];

       if ($request->hasFile('file')) {
        $file_extension = $request->file('file')->getClientOriginalExtension();
        $file           = $request->file('file')->storeAs('document',time().'.'.$file_extension );
        $data_employee_treatment['file'] = $file;
    }

      $this->EmployeeTreatmentService->UpdateData2($data_employee_treatment, $request->id);
     
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update employee treatment']);
    }

  }

  // public function updateEmployeeTreatment(Request $request){
  //   // $validator = Validator::make($request->all(),[ 
  //   //     'file' => 'required|mimes:doc,docx,pdf,jpg,png|max:1024',
  //   //   ]);   
 
  //   // if($validator->fails()) {          
            
  //   //   return response()->json(['error'=>$validator->errors()], 401);                        
  //   // }  

  //   if ($request->hasFile('file')) {
  //       $file_extension = $request->file('file')->getClientOriginalExtension();
  //       $file           = $request->file('file')->storeAs('document',time().'.'.$file_extension );
  //       // $url            = "http://127.0.0.1:8001/storage/".$file;
  //   try{
  //     $data_employee_treatment = [
  //     'name' => $request->name,
  //     'nik' => $request->nik,
  //     'unit' => $request->unit,
  //     'inspection_date' => $request->inspection_date,
  //     'head' => $request->head,
  //     'neck' => $request->neck,
  //     'eye' => $request->eye,
  //     'nose' => $request->nose,
  //     'tongue' => $request->tongue,
  //     'tooth' => $request->tooth,
  //     'gum' => $request->gum,
  //     'throat' => $request->throat,
  //     'tonsils' => $request->tonsils,
  //     'ear' => $request->ear,
  //     'lymph_nodes_and_neck' => $request->lymph_nodes_and_neck,
  //     'heart' => $request->heart,
  //     'lungs' => $request->lungs,
  //     'epigastrium' => $request->epigastrium,
  //     'hearts' => $request->hearts,
  //     'spleen' => $request->spleen,
  //     'intestines' => $request->intestines,
  //     'hand' => $request->hand,
  //     'foot' => $request->foot,
  //     'skin' => $request->skin,
  //     'diagnosis' => $request->diagnosis,
  //     'description' => $request->description,
  //     'file' => $file,
  //     'created_at' => Carbon::now(),
  //     'updated_at' => Carbon::now()
  //     ];

  //     $this->EmployeeTreatmentService->updateDataEmployeeTreatment($data_employee_treatment, $request->id);

     
  //     $data_general_physical_examination = [
  //       'awareness' => $request->awareness,
  //       'distress_sign' => $request->distress_sign,
  //       'anxiety_sign' => $request->anxiety_sign,
  //       'sign_of_pain' => $request->sign_of_pain,
  //       'voice' => $request->voice,
  //       //'employee_treat_id' => $lastId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $this->EmployeeTreatmentService->updateGeneralPhysicalExamination($data_general_physical_examination, $request->id);

  //     $data_vital_signs = [
  //     'blood_pressure' => $request->blood_pressure,
  //     'heart_rate' => $request->heart_rate,
  //     'breathing_ratio' => $request->breathing_ratio,
  //     'body_temperature' => $request->body_temperature,
  //     'sp02' => $request->sp02,
  //     //'employee_treat_id' => $lastId,
  //     'created_at' => Carbon::now(),
  //     'updated_at' => Carbon::now()
  //     ];
     
  //     $this->EmployeeTreatmentService->updateVitalSigns($data_vital_signs, $request->id); 

  //     $dynamicForm =  json_decode($request->dynamicForm, true);

  //     foreach($dynamicForm as $row){ 

  //     $location_drug= $row['location_drug'];
  //     $drug_name= $row['drug_name'];
  //     $amount_medicine= $row['amount_medicine'];
  //     $unit_drug= $row['unit_drug'];
  //     $how_to_use_medicine= $row['how_to_use_medicine'];
        
  //     $data_medical_prescription = [
  //     'location_drug' => $location_drug,
  //     'drug_name' => $drug_name,
  //     'amount_medicine' => $amount_medicine,
  //     'unit_drug' => $unit_drug,
  //     'how_to_use_medicine' => $how_to_use_medicine,
  //     //'employee_treat_id' => $lastId,
  //     'created_at' => Carbon::now(),
  //     'updated_at' => Carbon::now()
  //     ];

  //     $this->EmployeeTreatmentService->updateMedicalPrescription($data_medical_prescription, $request->id);
  //   }    
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed update employee treatment']);
  //   }
    
  // }

  // }

  public function deleteEmployeeTreatment(Request $request){
    try{      
      $this->EmployeeTreatmentService->deleteEmployeeTreatment($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete employee treatment']);
    }
  }

  public function downloadDocument(Request $request){
      // return $request;
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
