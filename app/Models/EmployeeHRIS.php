<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHRIS extends Model
{
    use HasFactory;
    protected $connection   = 'hris';
    protected $table        = 'employees';
    // protected $primaryKey   = 'emp_id';
    // protected $keyType      = 'string';
    public    $incrementing =  false;

    public function employeecareer(){
        return $this->hasOne(EmployeeCareer::class,'employee_id','id');
    }

     public function employeecontacts(){
        return $this->hasOne(EmployeeContacts::class,'employee_id','id');
    }

    public function employeeaddress(){
        return $this->hasOne(EmployeeAddress::class,'employee_id','id');
    }
}
