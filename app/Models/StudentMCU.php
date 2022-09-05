<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMCU extends Model
{
    use HasFactory;
    protected $table = 'student_mcus';
    protected $fillable = [
        'name',
        'niy',
        'level',
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
        'other',
        'suggestion',
        'created_at',
        'updated_at',
      ];

    public function studentexamination(){
        return $this->hasOne(StudentExamination::class, 'student_mcu_id');
    }
    // public function mcudiagnosis(){
    //     return $this->hasOne(MCUDiagnosis::class, 'id', 'dental_diagnosis');
    // }
    // public function visusdiagnosis(){
    //     return $this->hasOne(VisusDiagnosis::class, 'id', 'eye_diagnosis');
    // }
    // public function generaldiagnosis(){
    //     return $this->hasOne(GeneralDiagnosis::class, 'id', 'general_diagnosis');
    // }

    public function student(){
        return $this->belongsTo(Student::class, 'id');
    }

    public function tahunpelajaran(){
        return $this->belongsTo(TahunPelajaran::class, 'id');
    }

    public function jenjang(){
        return $this->belongsTo(Jenjang::class,'level', 'code');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class,'kelas', 'code');
    }

    public function studentmcugeneraldiagnosis(){
        return $this->hasMany(StudentMCUGeneralDiagnosis::class, 'student_mcu_id');
    }

    public function studentmcueyediagnosis(){
        return $this->hasMany(StudentMCUEyeDiagnosis::class, 'student_mcu_id');
    }

    public function studentmcudentalandoraldiagnosis(){
        return $this->hasMany(StudentMCUDentalAndOralDiagnosis::class, 'student_mcu_id');
    }

}
