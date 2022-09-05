<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeUnitTypes extends Model
{
    use HasFactory;
    protected $connection = "hris";
    protected $table = "employee_unit_types";

    public function employeecareer(){
        return $this->belongsTo(EmployeeCareer::class,'id','employee_unit_type_id');
    }

    public function employeeunit(){
        return $this->hasOne(EmployeeUnit::class,'employee_unit_type_id','id');
    }
}
