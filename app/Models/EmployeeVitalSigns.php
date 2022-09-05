<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeVitalSigns extends Model
{
    use HasFactory;
    protected $table = 'employee_vital_signs';
    protected $fillable = [
        'blood_pressure',
        'heart_rate',
        'breathing_ratio',
        'body_temperature',
        'sp02',
        'employee_treatment_id',
        'created_at',
        'updated_at',
      ];

      public function employeetreatment(){
        return $this->belongsTo(EmployeeTreatment ::class, 'id');
    }
}
