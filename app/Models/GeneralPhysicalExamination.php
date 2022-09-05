<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralPhysicalExamination extends Model
{
    use HasFactory;
    protected $table = 'employee_general_physical_examinations';
    protected $fillable = [
        'awareness',
        'distress_sign',
        'anxiety_sign',
        'sign_of_pain',
        'voice',
        'employee_treatment_id',
        'created_at',
        'updated_at',
    ];

    public function employeetreatment(){
        return $this->belongsTo(EmployeeTreatment ::class, 'id');
    }
}
