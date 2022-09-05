<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMCUDentalAndOralDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'student_m_c_u_dental_and_oral_diagnoses';
    protected $fillable = [
        'diagnosis_dental_id',
        'student_mcu_id',
        'created_at',
        'updated_at',
      ];

    public function studentmcu(){
        return $this->belongsTo(StudentMCU::class, 'id');
    }

    public function mcudiagnosis(){
        return $this->hasOne(MCUDiagnosis::class, 'id','diagnosis_dental_id');
    }
}
