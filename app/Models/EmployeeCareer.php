<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCareer extends Model
{
    use HasFactory;

    protected $connection = "hris";

    protected $table = "employee_careers";

    public function employeeunittypes(){
        return $this->hasOne(EmployeeUnitTypes::class,'id','employee_unit_type_id');
    }
    
    public function employeeposition(){
        return $this->hasOne(EmployeePosition::class,'id','employee_position_id');
    }

    public function employeeoccupation(){
        return $this->hasOne(EmployeeOccupation::class,'id');
    }

    public function transitionType(){
        return $this->belongsTo(EmployeeCareerTransitionType::class,'transition_type','id')->select('id','name');
    }

}
