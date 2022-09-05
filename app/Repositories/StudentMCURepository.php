<?php

namespace App\Repositories;

use App\Models\StudentMCU;
use App\Models\StudentMCUGeneralDiagnosis;
use App\Models\StudentMCUEyeDiagnosis;
use App\Models\StudentMCUDentalAndOralDiagnosis;
use App\Models\StudentExamination;
use App\Models\StudentMedicalPrescription;
use App\Models\EyeVisus;
use App\Models\BMIDiagnosis;
use App\Models\MCUDiagnosis;
use App\Models\VisusDiagnosis;
use App\Models\Student;
use App\Models\Jenjang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentMCURepository{
  protected $studentmcu;

  public function __construct(StudentMCU $studentmcu){
    $this->studentmcu = $studentmcu;
  }

  public function getEyeVisusById($id,$selects=['*']){
    return EyeVisus::select($selects)
    ->where('id','=',$id);
  }

  public function getBMIDiagnosisById($id,$selects=['*']){
    return EyeVisus::select($selects)
    ->where('id','=',$id);
  }

  public function getMCUDiagnosisById($id,$selects=['*']){
    return MCUDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getEyeVisusOptions($filters){
    return EyeVisus::select('id','od','os')
    ->when(isset($filters['od']), function ($query) use ($filters) {
      return $query->where('od','like','%'.$filters['od'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function getBMIDiagnosisOptions($filters){
    return BMIDiagnosis::select('id','diagnosis_name')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function getMCUDiagnosisOptions($filters){
    return MCUDiagnosis::select('id','diagnosis_kode','diagnosis_name','created_at')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }


  public function getStudentMCUOptions($filters){
    $student = Student::where('user_id', $filters['user_id'])->first();
    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }
    return StudentMCU::select('id',
    'level',
    'name',
    'niy',
    'kelas',
    'school_year',
    'inspection_date',
    'od_eyes',
    'os_eyes',
    'color_blind',
    'blood_pressure',
    'pulse',
    'respiration',
    'temperature',
    'dental_occlusion',
    'tooth_gap',
    'crowding_teeth',
    'dental_debris',
    'tartar',
    'tooth_abscess',
    'tongue',
    'other','suggestion','created_at')
    ->with(['student'=>function($query){
      $query->select('id', 'name');
    }])
    ->with(['jenjang'=>function($query){
      $query->select('id', 'name','code');
    }])
    ->with(['kelas'=>function($query){
      $query->select('id', 'name','code');
    }])
    ->with(['tahunpelajaran'=>function($query){
      $query->select('id', 'name');
    }])
    // ->with(['generaldiagnosis'=>function($query){
    //   $query->select('id', 'diagnosis_name');
    // }])
    //  ->with(['mcudiagnosis'=>function($query){
    //   $query->select('id', 'diagnosis_kode', 'diagnosis_name');
    // }])
    // ->with(['visusdiagnosis'=>function($query){
    //   $query->select('id', 'diagnosis_kode', 'diagnosis_name');
    // }])
    // ->with('studentexamination.bmidiagnosis')
    ->with(['studentexamination'=>function($query){
      $query->select('id','student_mcu_id', 'weight', 'height', 'bmi_calculation_results','bmi_diagnosis','gender','age','lk','lila','conclusion_lk','conclusion_lila');
    }])
    // ->with(['studentmcugeneraldiagnosis'=>function($query){
    //   $query->select('id','student_mcu_id','diagnosis_name');
    // }])
    ->with(['studentmcugeneraldiagnosis.generaldiagnosis'])
    ->with(['studentmcueyediagnosis.visusdiagnosis'])
    ->with(['studentmcudentalandoraldiagnosis.mcudiagnosis'])
    

    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($student) {
      return $query->where('niy','=', $student->niy);
    })

    ->when(isset($filters['level']), function ($query) use ($filters) {
        return $query->Where('level', $filters['level']);
      })
      ->when(isset($filters['kelas']), function ($query) use ($filters) {
        return $query->Where('kelas', $filters['kelas']);
      })
      ->when(isset($filters['inspection_date']), function ($query) use ($filters) {
        return $query->WhereDate('inspection_date','<=',$filters['inspection_date']);
      })
      ->when(isset($filters['created_at']), function ($query) use ($filters) {
        return $query->WhereDate('created_at','>=',$filters['created_at']);
      })
    // ->when(isset($filters['name']), function ($query) use ($filters) {
    //   return $query->where('name','like','%'.$filters['name'].'%');
    // })
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }


  public function geteyeDiagnosisOptions($filters){
    return VisusDiagnosis::select('id','diagnosis_kode','diagnosis_name','created_at')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function insert($data_student_mcu){
    $db = StudentMCU::create($data_student_mcu);
    return $db->id;
  }

  public function insert2($data_examination){
    StudentExamination::insert($data_examination);
  }

  public function insert3($data_diagnosis){
    StudentMCUGeneralDiagnosis::insert($data_diagnosis);
  }

  public function insert4($data_diagnosis){
    StudentMCUEyeDiagnosis::insert($data_diagnosis);
  }

  public function insert5($data_diagnosis){
    StudentMCUDentalAndOralDiagnosis::insert($data_diagnosis);
  }

  public function update($data_examination,$id){
    StudentExamination::where('id', $id)
            ->update($data_examination);
  }

  public function update2($data_student_mcu,$id){
    StudentMCU::where('id', $id)
            ->update($data_student_mcu);
  }

  public function update3($data_to_service, $id_general_diagnosis){
    StudentMCUGeneralDiagnosis::where('id', $id_general_diagnosis)
            ->update($data_to_service);
  }

  public function update4($data_to_service, $id_eye_diagnosis){
    StudentMCUEyeDiagnosis::where('id', $id_eye_diagnosis)
            ->update($data_to_service);
  }

  public function update5($data_to_service, $id_dental_and_oral_diagnosis){
    StudentMCUDentalAndOralDiagnosis::where('id', $id_dental_and_oral_diagnosis)
            ->update($data_to_service);
  }

  public function insertUpdate1($data_to_service){
    StudentMCUGeneralDiagnosis::insert($data_to_service);
  }

  public function insertUpdate2($data_to_service){
    StudentMCUEyeDiagnosis::insert($data_to_service);
  }

  public function insertUpdate3($data_to_service){
    StudentMCUDentalAndOralDiagnosis::insert($data_to_service);
  }

  public function deleteStudentMCU($ids){
    StudentMCU::whereIn('id', $ids)
            ->delete();
  }

}
