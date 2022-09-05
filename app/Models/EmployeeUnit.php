<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeUnit extends Model
{
    use HasFactory;
    protected $connection = "hris";
    protected $table = "employee_units";

    public function employeeposition(){
        return $this->hasOne(EmployeePosition::class,'id','employee_unit_id');
    }

    public function employeeunitypes(){
        return $this->belongsTo(EmployeeUnitTypes::class,'employee_unit_type_id','id');
    }

    public function employeetreatment(){
        return $this->hasOne(EmployeeTreatment::class,'unit','name');
    }

    public function employeemcu(){
        return $this->belongsTo(EmployeeMCU::class,'unit','name');
    }
}
