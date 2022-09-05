<?php

namespace App\Repositories;

use App\Models\StudentTreatment;
use App\Models\StudentTreatmentGeneralDiagnosis;
use App\Models\Anamnesis;
use App\Models\StudentGeneralPhysicalExamination;
use App\Models\StudentVitalSigns;
use App\Models\StudentMedicalPrescription;
use App\Models\Transactions;
use App\Models\GeneralDiagnosis;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentTreatmentRepository{
  protected $studenttreatment;

  public function __construct(StudentTreatment $studenttreatment){
    $this->studenttreatment = $studenttreatment;
  }

  public function getStudentTreatmentOptions($filters){
    $student = Student::where('user_id', $filters['user_id'])->first();
    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }
    return StudentTreatment::select(
      'id',
      'name',
      'niy',
      'level',
      'kelas',
      'inspection_date',
      'anamnesa',
      'head',
      'neck',
      'eye',
      'nose',
      'tongue',
      'tooth',
      'gum',
      'throat',
      'tonsils',
      'ear',
      'lymph_nodes_and_neck',
      'heart',
      'lungs',
      'epigastrium',
      'hearts',
      'spleen',
      'intestines',
      'hand',
      'foot',
      'skin',
      'description',
      'created_at')
    ->with(['student'=>function($query){
      $query->select('id', 'name');
    }])
    ->with(['jenjang'=>function($query){
      $query->select('id', 'name','code');
    }])
    ->with(['kelas'=>function($query){
      $query->select('id', 'name','code');
    }])
    ->with(['studentgeneralphysicalexamination'=>function($query){
      $query->select('awareness',
        'distress_sign',
        'anxiety_sign',
        'sign_of_pain',
        'voice',
        'student_treat_id');
    }])
    ->with(['studentvitalsigns'=>function($query){
      $query->select(
        'blood_pressure',
        'heart_rate',
        'breathing_ratio',
        'body_temperature',
        'sp02',
        'student_treat_id');
    }])
    // ->with(['generaldiagnosis'=>function($query){
    //   $query->select('id',
    //     'diagnosis_name');
    // }])
    ->with(['studenttreatmentgeneraldiagnosis.generaldiagnosis'])
     ->with('studentmedicalprescription.drugname')
      ->with('studentmedicalprescription.listofukslocations')

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


  //  public function reduceStock($filters){
  //    $drug_id = $filters['drug_id'];
  //    $location_id = $filters['location_id'];
  //    $drug_expired_id = $filters['drug_expired_id'];
  //    $qty = $filters['qty'];
  //    $reduce = DB::select("SELECT a1.drug_id, a1.location_id, a1.drug_expired_id, a1.stok_awal - a1.qty as stok_akhir FROM (SELECT a.qty as stok_awal, a.drug_id, a.location_id, a.drug_expired_id,
  //                         (SELECT COALESCE(SUM(b.qty), 0) from transactions b 
  //                         WHERE b.drug_id = a.drug_id AND b.location_id = a.location_id AND a.drug_expired_id = b.drug_expired_id) as qty
  //                         FROM stocks a
  //                         ) a1 WHERE a1.drug_id = 1;");
 
  //    return $reduce;
  // }


  public function insert($data_student_treatment){
    $db = StudentTreatment::create($data_student_treatment);
    return $db->id;
  }

  public function insert2($data_general_physical_examination){
    StudentGeneralPhysicalExamination::insert($data_general_physical_examination);
  }

  public function insert3($data_vital_signs){
    StudentVitalSigns::insert($data_vital_signs);
  }

  public function insert4($data_medical_prescription){
    
    StudentMedicalPrescription::insert($data_medical_prescription);
    
  }

  public function insert5($transactions){
    Transactions::insert($transactions);
  }

  public function insert6($data_general_diagnosis){
     StudentTreatmentGeneralDiagnosis::insert($data_general_diagnosis);
  }

  public function update($data_to_service, $id_medical){
    StudentMedicalPrescription::where('id', $id_medical)
            ->update($data_to_service);
  }

  public function update2($data_student_treatment, $id){
    StudentTreatment::where('id', $id)
            ->update($data_student_treatment);
  }

  public function update3($data_general_physical_examination, $id){
    StudentGeneralPhysicalExamination::where('id', $id)
            ->update($data_general_physical_examination);
  }

  public function update4($data_vital_signs, $id){
    StudentVitalSigns::where('id', $id)
            ->update($data_vital_signs);
  }

  public function update5($data_to_service, $id_general_diagnosis){
    StudentTreatmentGeneralDiagnosis::where('id', $id_general_diagnosis)
            ->update($data_to_service);
  }

  public function insertUpdate($data_to_service){
    StudentMedicalPrescription::insert($data_to_service);
  }

  public function insertUpdate1($data_to_service){
    StudentTreatmentGeneralDiagnosis::insert($data_to_service);
  }

  public function deleteStudentTreatment($ids){
    StudentTreatment::whereIn('id', $ids)
            ->delete();
  }

}
