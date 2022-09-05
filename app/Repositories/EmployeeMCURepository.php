<?php

namespace App\Repositories;

use App\Models\EmployeeMCU;
use App\Models\EmployeeMCUGeneralDiagnosis;
use App\Models\EmployeeHRIS;
use Carbon\Carbon;

class EmployeeMCURepository{
  protected $employeemcu;

  public function __construct(EmployeeMCU $employeemcu){
    $this->employeemcu = $employeemcu;
  }

  public function getEmployeeMCUOptions($filters){
    $employee = EmployeeHRIS::where('user_id', $filters['user_id'])->first();

    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }
    return EmployeeMCU::select(
      'id',
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
      'updated_at')
    ->with(['employeeunit'=>function($query){
      $query->select('id', 'name');
    }])
    ->with(['employeemcugeneraldiagnosis.generaldiagnosis'])


    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($employee) {
      return $query->where('nik','=', $employee->nik);
    })
    
     ->when(isset($filters['unit']), function ($query) use ($filters) {
              return $query->Where('unit', $filters['unit']);
            })
     ->when(isset($filters['inspection_date']), function ($query) use ($filters) {
        return $query->WhereDate('inspection_date','<=',$filters['inspection_date']);
      })
      ->when(isset($filters['created_at']), function ($query) use ($filters) {
        return $query->WhereDate('created_at','>=',$filters['created_at']);
      })
    // ->when(isset($filters['name']), function ($query) use ($filters) {
    //   return $query->where('name','like','%'.$filters['name'].'%');
    // }) 
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }


  public function insert($data_employee_mcu){
    $db = EmployeeMCU::create($data_employee_mcu);
    return $db->id;
  }

  public function insert1($data_general_diagnosis){
    EmployeeMCUGeneralDiagnosis::insert($data_general_diagnosis);
  }

  public function update($data_employee_mcu, $id){
    EmployeeMCU::where('id', $id)
            ->update($data_employee_mcu);
  }

  public function update1($data_to_service, $id_diagnosis){
    EmployeeMCUGeneralDiagnosis::where('id', $id_diagnosis)
            ->update($data_to_service);
  }

  public function insertUpdate1($data_to_service){
   EmployeeMCUGeneralDiagnosis::insert($data_to_service);
  }

  public function deleteEmployeeMCU($ids){
    EmployeeMCU::whereIn('id', $ids)
            ->delete();

  }

}
