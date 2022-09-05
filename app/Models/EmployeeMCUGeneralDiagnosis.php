<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMCUGeneralDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'employee_m_c_u_general_diagnoses';
    protected $fillable = [
        'diagnosis_id',
        'employee_mcu_id',
        'created_at',
        'updated_at',
      ];

    public function employeemcu(){
        return $this->belongsTo(EmployeeMCU::class, 'id');
    }

    public function generaldiagnosis(){
        return $this->hasOne(GeneralDiagnosis::class, 'id','diagnosis_id');
    }

}
