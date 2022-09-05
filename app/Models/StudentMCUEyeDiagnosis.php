<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMCUEyeDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'student_m_c_u_eye_diagnoses';
    protected $fillable = [
        'diagnosis_eye_id',
        'student_mcu_id',
        'created_at',
        'updated_at',
      ];

    public function studentmcu(){
        return $this->belongsTo(StudentMCU::class, 'id');
    }

     public function visusdiagnosis(){
        return $this->hasOne(VisusDiagnosis::class, 'id','diagnosis_eye_id');
    }
}
