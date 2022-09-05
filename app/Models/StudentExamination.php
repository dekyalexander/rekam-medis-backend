<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamination extends Model
{
    use HasFactory;
    protected $table = 'student_examinations';
    protected $fillable = [
        'weight',
        'height',
        'bmi_calculation_results',
        'bmi_diagnosis',
        'gender',
        'age',
        'lk',
        'lila',
        'conclusion_lk',
        'conclusion_lila',
        'student_mcu_id',
        'created_at',
        'updated_at',
      ];

      public function studentmcu(){
        return $this->belongsTo(StudentMCU::class, 'id');
    }

    public function bmidiagnosis(){
        return $this->hasOne(BMIDiagnosis::class, 'id', 'bmi_diagnosis');
    }
}
