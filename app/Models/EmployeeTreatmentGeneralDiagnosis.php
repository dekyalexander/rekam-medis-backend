<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTreatmentGeneralDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'employee_treatment_general_diagnoses';
    protected $fillable = [
        'diagnosis_id',
        'employee_treat_id',
        'created_at',
        'updated_at',
      ];

    public function employeetreatment(){
        return $this->belongsTo(EmployeeTreatment::class, 'id');
    }

    public function generaldiagnosis(){
        return $this->hasOne(GeneralDiagnosis::class, 'id','diagnosis_id');
    }
}
