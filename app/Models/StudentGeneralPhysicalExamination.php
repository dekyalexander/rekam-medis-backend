<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGeneralPhysicalExamination extends Model
{
    use HasFactory;
    protected $table = 'student_general_physical_examinations';
    protected $fillable = [
        'awareness',
        'distress_sign',
        'anxiety_sign',
        'sign_of_pain',
        'voice',
        'student_treatment_id',
        'created_at',
        'updated_at',
    ];

    public function studenttreatment(){
        return $this->belongsTo(StudentTreatment ::class, 'id');
    }
}
