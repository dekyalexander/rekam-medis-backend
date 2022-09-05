<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMCU extends Model
{
    use HasFactory;
    protected $table = 'employee_mcus';
    protected $fillable = [
        'name',
        'nik',
        'unit',
        'inspection_date',
        'blood_pressure',
        'heart_rate',
        'breathing_ratio',
        'body_temperature',
        'sp02',
        'weight',
        'height',
        'bmi_calculation_results',
        'bmi_diagnosis',
        'file',
        'created_at',
        'updated_at',
      ];

    public function employeemcugeneraldiagnosis(){
        return $this->hasMany(EmployeeMCUGeneralDiagnosis::class, 'employee_mcu_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'id');
    }

    public function employeeunit(){
        return $this->belongsTo(EmployeeUnit::class,'unit','name');
    }
}
