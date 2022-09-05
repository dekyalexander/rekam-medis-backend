<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BMIDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'bmi_diagnosis';
    protected $fillable = [
        'diagnosis_name',
        'created_at',
        'updated_at',
      ];

    // public function studentmcu(){
    //     return $this->belongsTo(StudentMCU::class, 'id', 'student_mcu_id', 'bmi_diagnosis');
    // }

    public function studentexamination(){
        return $this->belongsTo(StudentExamination::class, 'id', 'student_mcu_id', 'bmi_diagnosis');
    }
}
