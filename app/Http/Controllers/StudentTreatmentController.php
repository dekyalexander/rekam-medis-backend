<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StudentTreatmentService;
use App\Services\DrugService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentTreatmentController extends Controller
{
    protected $StudentTreatmentService;

  public function __construct(StudentTreatmentService $StudentTreatmentService, DrugService $DrugService){
    $this->StudentTreatmentService = $StudentTreatmentService;
    $this->DrugService = $DrugService;
  }

  public function getStudentTreatmentOptions(Request $request){
    $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id,
      'name' => $request->name,
      'keyword'=>$request->keyword,
      'level' => $request->level,
      'kelas' => $request->kelas,
      'inspection_date' => $request->inspection_date,
      'created_at' => $request->created_at,
    ];
    return $this->StudentTreatmentService->getStudentTreatmentOptions($filters);
  }

  //  public function reduceStock(Request $request){
  //   $filters=[
  //     'drug_id' => $request->drug_id,
  //     'drug_expired_id' => $request->drug_expired_id,
  //     'location_id' => $request->location_id,
  //     'qty' => $request->qty,
  //   ];
  //   return $this->StudentTreatmentService->reduceStock($filters);
  // }

  public function createStudentTreatment(Request $request){
    try{
      $data_student_treatment = [
      'name' => $request->name,
      'niy' => $request->niy,
      'level' => $request->level,
      'kelas' => $request->kelas,
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
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $lastId = $this->StudentTreatmentService->createDataStudentTreatment($data_student_treatment);

     
      $data_general_physical_examination = [
        'awareness' => $request->awareness,
        'distress_sign' => $request->distress_sign,
        'anxiety_sign' => $request->anxiety_sign,
        'sign_of_pain' => $request->sign_of_pain,
        'voice' => $request->voice,
        'student_treat_id' => $lastId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->StudentTreatmentService->createGeneralPhysicalExamination($data_general_physical_examination);

      $data_vital_signs = [
      'blood_pressure' => $request->blood_pressure,
      'heart_rate' => $request->heart_rate,
      'breathing_ratio' => $request->breathing_ratio,
      'body_temperature' => $request->body_temperature,
      'sp02' => $request->sp02,
      'student_treat_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];
      
      $this->StudentTreatmentService->createVitalSigns($data_vital_signs); 
      
      
      $dynamicFormGeneralDiagnosis =  json_decode($request->dynamicFormGeneralDiagnosis, true);

      if (is_array($dynamicFormGeneralDiagnosis ) || is_object($dynamicFormGeneralDiagnosis )){

      foreach($dynamicFormGeneralDiagnosis['studenttreatmentgeneraldiagnosis'] as $row){ 

      $diagnosis_id = $row['diagnosis_id'];

      $data_general_diagnosis = [
      'diagnosis_id' =>$diagnosis_id,
      'student_treat_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->StudentTreatmentService->createGeneralDiagnosis($data_general_diagnosis);
    }
  }
      
      $dynamicForm =  json_decode($request->dynamicForm, true);

      // var_dump($dynamicForm['studentmedicalprescription'][0]);

      if (is_array($dynamicForm ) || is_object($dynamicForm )){

      foreach($dynamicForm['studentmedicalprescription'] as $row){

        
      // Object Pengurangan Jumlah Stok Dan Jumlah Ambil Obat
        
      $qty_update = $row['qty'] - $row['amount_medicine'];

      // Ambil Id Obat Distribusi Dari Frontend

      $drug_distribution_id = $row['drug_distribution_id'];

      $location_id = $row['location_id'];
      $drug_id = $row['drug_id'];
      $amount_medicine = $row['amount_medicine'];
      $unit = $row['unit'];
      $how_to_use_medicine = $row['how_to_use_medicine'];
      // Objek Jumlah Stok Yang Dikirim Atau Disimpan
      $qty = $qty_update;
      $date_expired = $row['date_expired'];
      $description= $row['description'];

      // var_dump($location_drug);
        
      $data_medical_prescription = [
      'location_id' => $location_id,
      'drug_id' => $drug_id,
      'amount_medicine' => $amount_medicine,
      'unit' => $unit,
      'how_to_use_medicine' => $how_to_use_medicine,
      'student_treat_id' => $lastId,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
      ];

      $this->StudentTreatmentService->createMedicalPrescription($data_medical_prescription);

      
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
      
      $this->StudentTreatmentService->createTransactions($transactions);
    }
  }
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create student treatment']);
    }

  }

  public function updateStudentTreatment(Request $request){
    try{

      $data_to_service = array();

       $dynamicFormGeneralDiagnosis =  json_decode($request->dynamicFormGeneralDiagnosis, true);
          
            if (is_array($dynamicFormGeneralDiagnosis ) || is_object($dynamicFormGeneralDiagnosis )){


            foreach($dynamicFormGeneralDiagnosis['studenttreatmentgeneraldiagnosis'] as $row){ 
  
            $data_to_service = [
                                  'diagnosis_id'=> $row['diagnosis_id'],
                                  'updated_at' => Carbon::now()
                                ];

            if(!empty($row['id'])){
              $id_general_diagnosis = $row['id'];
            }else{
             $id_general_diagnosis = '';
            }
            
            $this->StudentTreatmentService->updateData5($data_to_service, $request->id, $id_general_diagnosis); 

            }
           

          }

      $dynamicForm =  json_decode($request->dynamicForm, true);

      // var_dump($dynamicForm['studentmedicalprescription'][0]);

       if (is_array($dynamicForm) || is_object($dynamicForm )){

      foreach($dynamicForm['studentmedicalprescription'] as $row){ 

       $data_to_service = [
                                  'location_id'=> $row['location_id'],
                                  'drug_id'=> $row['drug_id'],
                                  'amount_medicine'=> $row['amount_medicine'],
                                  'unit'=> $row['unit'],
                                  'how_to_use_medicine'=> $row['how_to_use_medicine'],
                                  'updated_at' => Carbon::now()
                                ];

      // var_dump($location_drug);

      if(!empty($row['id'])){
              $id_medical = $row['id'];
            }else{
             $id_medical = '';
            }

      $this->StudentTreatmentService->UpdateData($data_to_service, $request->id, $id_medical);

      }
    }


      $data_student_treatment = [
      'name' => $request->name,
      'niy' => $request->niy,
      'level' => $request->level,
      'kelas' => $request->kelas,
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

      $this->StudentTreatmentService->updateData2($data_student_treatment, $request->id);

      $data_general_physical_examination = [
        'awareness' => $request->awareness,
        'distress_sign' => $request->distress_sign,
        'anxiety_sign' => $request->anxiety_sign,
        'sign_of_pain' => $request->sign_of_pain,
        'voice' => $request->voice,
        'updated_at' => Carbon::now()
      ];

      $this->StudentTreatmentService->updateData3($data_general_physical_examination, $request->id);

      $data_vital_signs = [
      'blood_pressure' => $request->blood_pressure,
      'heart_rate' => $request->heart_rate,
      'breathing_ratio' => $request->breathing_ratio,
      'body_temperature' => $request->body_temperature,
      'sp02' => $request->sp02,
      'updated_at' => Carbon::now()
      ];
      
      $this->StudentTreatmentService->updateData4($data_vital_signs, $request->id);  

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update student treatment']);
    }

  }

  public function deleteStudentTreatment(Request $request){
    try{      
      $this->StudentTreatmentService->deleteStudentTreatment($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete student treatment']);
    }
  }


}
