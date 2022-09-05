<?php

namespace App\Services;
use App\Repositories\StudentMCURepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class StudentMCUService{
    protected $studentmcuRepository;

    public function __construct(StudentMCURepository $studentmcuRepository){
	    $this->studentmcuRepository = $studentmcuRepository;
    }

    public function getEyeVisusOptions($filters){
	    return $this->studentmcuRepository->getEyeVisusOptions($filters)->get();
    }

    public function getBMIDiagnosisOptions($filters){
	    return $this->studentmcuRepository->getBMIDiagnosisOptions($filters)->get();
    }

    public function getMCUDiagnosisOptions($filters){
	    return $this->studentmcuRepository->getMCUDiagnosisOptions($filters)->get();
    }

    public function geteyeDiagnosisOptions($filters){
	    return $this->studentmcuRepository->geteyeDiagnosisOptions($filters)->get();
    }

    public function getStudentMCUOptions($filters, $rowsPerPage=25){
	    return $this->studentmcuRepository->getStudentMCUOptions($filters)->paginate($rowsPerPage);
    }

    public function createDataStudentMCU($data_student_mcu){
        return $this->studentmcuRepository->insert($data_student_mcu);
    }

    public function createStudentMCU($data_examination){
        $this->studentmcuRepository->insert2($data_examination);
    }

    public function createGeneralDiagnosis($data_diagnosis){
        $this->studentmcuRepository->insert3($data_diagnosis);
    }

    public function createEyeDiagnosis($data_diagnosis){
        $this->studentmcuRepository->insert4($data_diagnosis);
    }

    public function createDentalAndOralDiagnosis($data_diagnosis){
        $this->studentmcuRepository->insert5($data_diagnosis);
    }

    public function updateData3($data_to_service, $id, $id_general_diagnosis){
           
        if($id_general_diagnosis!=''){
          $response = $this->studentmcuRepository->update3($data_to_service, $id_general_diagnosis);
        }else {
            $data_to_service = [
                                  'student_mcu_id'=> $id,
                                  'diagnosis_general_id'=> $data_to_service['diagnosis_general_id'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->studentmcuRepository->insertUpdate1($data_to_service);
        }

        return $response;
    }

    public function updateData4($data_to_service, $id, $id_eye_diagnosis){
           
        if($id_eye_diagnosis!=''){
          $response = $this->studentmcuRepository->update4($data_to_service, $id_eye_diagnosis);
        }else {
            $data_to_service = [
                                  'student_mcu_id'=> $id,
                                  'diagnosis_eye_id'=> $data_to_service['diagnosis_eye_id'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->studentmcuRepository->insertUpdate2($data_to_service);
        }

        return $response;
    }

    public function updateData5($data_to_service, $id, $id_dental_and_oral_diagnosis){
           
        if($id_dental_and_oral_diagnosis!=''){
          $response = $this->studentmcuRepository->update5($data_to_service, $id_dental_and_oral_diagnosis);
        }else {
            $data_to_service = [
                                  'student_mcu_id'=> $id,
                                  'diagnosis_dental_id'=> $data_to_service['diagnosis_dental_id'],
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now()
                                ];

          $response = $this->studentmcuRepository->insertUpdate3($data_to_service);
        }

        return $response;
    }

    public function updateData($data_examination, $id){
        $this->studentmcuRepository->update($data_examination, $id);
    }

    public function updateData2($data_student_mcu, $id){
        $this->studentmcuRepository->update2($data_student_mcu, $id);
    }

    public function deleteStudentMCU($ids){
      $this->studentmcuRepository->deleteStudentMCU($ids);          
    }
        
}
