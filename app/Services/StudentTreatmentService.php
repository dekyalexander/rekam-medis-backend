<?php

namespace App\Services;
use App\Repositories\StudentTreatmentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class StudentTreatmentService{
    protected $studenttreatmentRepository;

    public function __construct(StudentTreatmentRepository $studenttreatmentRepository){
	    $this->studenttreatmentRepository = $studenttreatmentRepository;
    }

    public function getStudentTreatmentOptions($filters, $rowsPerPage=25){
	    return $this->studenttreatmentRepository->getStudentTreatmentOptions($filters)->paginate($rowsPerPage);
    }

    // public function reduceStock($filters){
	//     return $this->studenttreatmentRepository->reduceStock($filters);
    // }

    public function createDataStudentTreatment($data_student_treatment){
        return $this->studenttreatmentRepository->insert($data_student_treatment);
    }

    public function createGeneralPhysicalExamination($data_general_physical_examination){
        $this->studenttreatmentRepository->insert2($data_general_physical_examination);
    }

    public function createVitalSigns($data_vital_signs){
        $this->studenttreatmentRepository->insert3($data_vital_signs);
    }

    public function createGeneralDiagnosis($data_general_diagnosis){
        $this->studenttreatmentRepository->insert6($data_general_diagnosis);
    }

    public function createMedicalPrescription($data_medical_prescription){
        $this->studenttreatmentRepository->insert4($data_medical_prescription);
    }

    public function createTransactions($transactions){
        $this->studenttreatmentRepository->insert5($transactions);
    }

    public function updateData($data_to_service, $id, $id_medical){
        

        if($id_medical!=''){
          $response = $this->studenttreatmentRepository->update($data_to_service, $id_medical);
        }else {
          $data_to_service = [
                                      'student_treat_id'=> $id,
                                      'location_id'=> $data_to_service['location_id'],
                                      'drug_id'=> $data_to_service['drug_id'],
                                      'amount_medicine'=> $data_to_service['amount_medicine'],
                                      'unit'=> $data_to_service['unit'],
                                      'how_to_use_medicine'=> $data_to_service['how_to_use_medicine'],
                                      'created_at' => Carbon::now(),
                                      'updated_at' => Carbon::now()
                                      ];
          $response = $this->studenttreatmentRepository->insertUpdate($data_to_service);
        }

        return $response;
    }

    public function updateData2($data_student_treatment, $id){
        $this->studenttreatmentRepository->update2($data_student_treatment, $id);
    }

    public function updateData3($data_general_physical_examination, $id){
        $this->studenttreatmentRepository->update3($data_general_physical_examination, $id);
    }

    public function updateData4($data_vital_signs, $id){
        $this->studenttreatmentRepository->update4($data_vital_signs, $id);
    }

    public function updateData5($data_to_service, $id, $id_general_diagnosis){
           
        if($id_general_diagnosis!=''){
          $response = $this->studenttreatmentRepository->update5($data_to_service, $id_general_diagnosis);
        }else {
            $data_to_service = [
                                  'student_treat_id'=> $id,
                                  'diagnosis_id'=> $data_to_service['diagnosis_id'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->studenttreatmentRepository->insertUpdate1($data_to_service);
        }

        return $response;
    }

    public function deleteStudentTreatment($ids){
      $this->studenttreatmentRepository->deleteStudentTreatment($ids);          
    }
        
}
