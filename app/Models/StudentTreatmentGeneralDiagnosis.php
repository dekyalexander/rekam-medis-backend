<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTreatmentGeneralDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'student_treatment_general_diagnoses';
    protected $fillable = [
        'diagnosis_id',
        'student_treat_id',
        'created_at',
        'updated_at',
      ];

    public function studenttreatment(){
        return $this->belongsTo(StudentTreatment::class, 'id');
    }

    public function generaldiagnosis(){
        return $this->hasOne(GeneralDiagnosis::class, 'id','diagnosis_id');
    }
}
