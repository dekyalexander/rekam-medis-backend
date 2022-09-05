<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\EmployeeHRIS;
use Carbon\Carbon;

class EmailRepository{
  protected $studentemail;
  protected $employeemail;

  public function __construct(Student $studentemail, EmployeeHRIS $employeemail){
    $this->studentemail = $studentemail;
    $this->employeemail = $employeemail;
  }

  public function getstudentEmailOptions($filters){

  $jenjang_id = $filters['jenjang_id'];

  $studentemail = Student::select('name','email','jenjang_id','mother_parent_id','father_parent_id')
    ->with(['jenjang:id,name,code'])
    ->with(['parent_mother:id,email'])
    ->with(['parent_father:id,email']);
    if($jenjang_id){
                $studentemail->WhereHas('jenjang', function ($q) use($jenjang_id) {
                  return $q->where('jenjang_id', $jenjang_id);
                });
              }
    
    return $studentemail;

}

 public function getemployeeEmailOptions($filters){

  $unit_id = $filters['id'];

  $employeeemail = EmployeeHRIS::select('id','name')
    ->with('employeecareer.employeeposition.employeeunit:id,name') 
    ->with('employeecontacts:id,employee_id,email')
    ->whereHas('employeecareer.transitionType', function($query) {
      $query->where('status','=',1);
    });

   if($unit_id){
                $employeeemail->WhereHas('employeecareer.employeeposition.employeeunit', function ($q) use($unit_id) {
                  return $q->where('id', $unit_id);
                });
              }
    
  return $employeeemail;

}

}
