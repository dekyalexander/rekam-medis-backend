<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\EmployeeHRIS;
use Carbon\Carbon;

class EmployeeRepository{
  protected $employee;
  protected $employeehris;

  public function __construct(Employee $employee, EmployeeHRIS $employeehris){
    $this->employee = $employee;
    $this->employeehris = $employeehris;
  }

  public function getEmployeeById($id,$selects=['*']){
    return Employee::select($selects)
    ->where('id','=',$id);
  }

  public function getEmployeesByFilters($filters)
  {
    // return  
    // Employee::with([
    //   'user'
    //   ])
    return EmployeeHRIS::select('id','name','nik')
    ->with('employeecareer.employeeposition.employeeunit:id,name') 
    ->with('employeecontacts:id,employee_id,handphone,telephone,email') 
    ->with('employeeaddress:id,employee_id,address') 
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['name']), function ($query) use ($filters) {
        return $query->where('name','like','%'.$filters['name'].'%');
    })->whereHas('employeecareer.transitionType', function($query) {
      $query->where('status','=',1);
    });
  }

  // public function getEmployeeOptions($keyword){
  //   return Employee::select('id','name')
  //   ->when(isset($keyword), function ($query) use ($keyword) {
  //     return $query->where('name','like','%'.$keyword.'%');
  //   });
  // }

  // public function getEmployeeOptions($keyword){
  //   return EmployeeHRIS::select('id','name','nik')
  //   ->with(['employeecareer'=>function($query){
  //     $query->select('id', 'employee_id','employee_position_id','employee_occupation_id','employee_unit_type_id');
  //   }])
  //   ->with(['employeeunittypes'=>function($query){
  //     $query->select('id','name');
  //   }])
  //   ->with(['employeeoccupation'=>function($query){
  //     $query->select('id','name','employee_unit_type_id');
  //   }])
  //   ->with(['employeeposition'=>function($query){
  //     $query->select('id','employee_unit_id');
  //   }])
  //   ->with(['employeeunit'=>function($query){
  //     $query->select('id','name');
  //   }])
  //   ->when(isset($keyword), function ($query) use ($keyword) {
  //     return $query->where('name','like','%'.$keyword.'%');
  //   });
  // }

  public function getEmployeeOptions($filters){
     $employee = EmployeeHRIS::where('user_id', $filters['user_id'])->first();
     if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }

    // echo "tes".$roles_id;
    
    return EmployeeHRIS::select('id','name','nik')
    // ->with(['employeecareer'=>function($query){
    //   $query->select('id', 'employee_id','employee_position_id','employee_occupation_id','employee_unit_type_id');
    // }])
    // ->with(['employeeunittypes'=>function($query){
    //   $query->select('id','name');
    // }])
    // ->with(['employeeoccupation'=>function($query){
    //   $query->select('id','name','employee_unit_type_id');
    // }])
    // ->with(['employeeposition'=>function($query){
    //   $query->select('id','employee_unit_id');
    // }])
    // ->with(['employeeunit'=>function($query){
    //   $query->select('id','name');
    // }])
    ->with('employeecareer.employeeposition.employeeunit:id,name') 
    ->with('employeecontacts:id,employee_id,handphone,telephone,email') 
    ->with('employeeaddress:id,employee_id,address')
    ->whereHas('employeecareer.transitionType', function($query) {
      $query->where('status','=',1);
    }) 
    

    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($employee) {
      return $query->where('nik','=', $employee->nik);
    })
    
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function insertEmployee($data){
    Employee::insert($data);
  }

  public function insertEmployeeGetId($data){
    return Employee::insertGetId($data);
  }

  public function insertGetEmployee($data){
    return Employee::create($data);
  }

  public function updateEmployee($data,$id){
    Employee::where('id', $id)
            ->update($data);
  }
  
  public function deleteEmployees($ids){
    Employee::whereIn('id', $ids)
            ->delete();
  }
}
