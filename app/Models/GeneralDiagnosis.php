<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'general_diagnosis';
    protected $fillable = [
        'diagnosis_kode',
        'diagnosis_name',
        'created_at',
        'updated_at',
      ];

    // public function studentmcu(){
    //     return $this->belongsTo(StudentMCU::class, 'id','general_diagnosis');
    // }
    public function studentmcugeneraldiagnosis(){
        return $this->belongsTo(StudentMCUGeneralDiagnosis::class, 'id','diagnosis_general_id');
    }
    public function studenttreatmentgeneraldiagnosis(){
        return $this->belongsTo(StudentTreatmentGeneralDiagnosis::class, 'id','diagnosis_id');
    }
     public function employeetreatmentgeneraldiagnosis(){
        return $this->belongsTo(EmployeeTreatmentGeneralDiagnosis::class, 'id','diagnosis_id');
    }
     public function employeemcugeneraldiagnosis(){
        return $this->belongsTo(EmployeeMCUGeneralDiagnosis::class, 'id','diagnosis_id');
    }
    // public function studenttreatment(){
    //     return $this->belongsTo(StudentTreatment::class, 'id','diagnosis');
    // }
    // public function employeetreatment(){
    //     return $this->belongsTo(EmployeeTreatment::class, 'id','diagnosis');
    // }
}
