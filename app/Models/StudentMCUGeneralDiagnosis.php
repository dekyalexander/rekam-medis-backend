<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMCUGeneralDiagnosis extends Model
{
     use HasFactory;
    protected $table = 'student_m_c_u_general_diagnoses';
    protected $fillable = [
        'diagnosis_general_id',
        'student_mcu_id',
        'created_at',
        'updated_at',
      ];

    public function studentmcu(){
        return $this->belongsTo(StudentMCU::class, 'id');
    }

     public function generaldiagnosis(){
        return $this->hasOne(GeneralDiagnosis::class, 'id','diagnosis_general_id');
    }
}
