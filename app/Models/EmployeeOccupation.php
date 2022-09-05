<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeOccupation extends Model
{
    use HasFactory;
    protected $connection = "hris";
    protected $table = "employee_occupations";

    public function employeecareer(){
        return $this->belongsTo(EmployeeCareer::class,'employee_occupation_id');
    }
    
    public function employeeunittypes(){
        return $this->belongsTo(EmployeeUnitTypes::class,'employee_unit_type_id','id');
    }
}
