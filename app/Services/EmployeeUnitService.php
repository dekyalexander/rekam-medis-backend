<?php

namespace App\Services;
use App\Repositories\EmployeeUnitRepository;

class EmployeeUnitService
{
    protected $employeeUnitRepository;
  
    public function __construct(EmployeeUnitRepository $employeeUnitRepository)
    {
      $this->employeeUnitRepository = $employeeUnitRepository;
    }  
    
    public function getData($request){
    	return $this->employeeUnitRepository->getData($request);
    }
    
    public function getOption($request){
        return $this->employeeUnitRepository->getOptions($request);
    }
}