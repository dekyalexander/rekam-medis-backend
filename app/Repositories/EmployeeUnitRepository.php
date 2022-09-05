<?php

namespace App\Repositories;

use App\Models\EmployeeUnit;

class EmployeeUnitRepository
{
  protected $employeeUnit;

  public function __construct(EmployeeUnit $employeeUnit)
  {
      $this->employeeUnit = $employeeUnit;
  }

  public function getData($request){
    return $this->employeeUnit::with('employeeUnitType')->orderBy('name')->get();
  }

  public function getOptions($request)
  {
      return $this->employeeUnit::select('id','name')
            ->when(isset($request->unit_type) && ($request->unit_type != 'all') , function($query) use ($request){
                return $query->where('employee_unit_type_id ',$request->unit_type);
            })
            ->orderBy('name')
            ->get();
  }

}