<?php

namespace App\Services;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EmployeeService{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository){
	    $this->employeeRepository = $employeeRepository;
    }

    public function getEmployeesByFilters($filters){
	    return $this->employeeRepository
      ->getEmployeesByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->employeeRepository
      ->getEmployeesByFilters($filters)      
      ->paginate($rowsPerPage);
    }

    public function getEmployeeOptions($filters){
	    return $this->employeeRepository->getEmployeeOptions($filters)->get();
    }

    public function createEmployee($data){
      $this->employeeRepository->insertEmployee($data);
  	}   

    public function updateEmployee($data, $id){
      $this->employeeRepository->updateEmployee($data, $id);
    }

    public function deleteEmployees($ids){
      $this->employeeRepository->deleteEmployees($ids);          
    }    
 
        
}
