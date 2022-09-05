<?php
namespace App\Repositories;
use App\Models\EmployeeCareer;

class EmployeeCareerRepository
{
    protected $employeeCareer;

    public function __construct(EmployeeCareer $employeeCareer)
    {
        $this->employeeCareer = $employeeCareer;
    }

    public function getEmployeeCareers($user_id){
        return $this->employeeCareer
            ->where('employee_id',$user_id)
            ->with([
                'employeeposition:id,mpp_information_id,tahun_pelajaran,code,name,parent,employee_occupation_id,employee_unit_id',
                'employeeposition.employeeunit:id,name,employee_unit_type_id',
                'employeeposition.employeeunit.employeeunitypes:id,name',
                // 'employeeoccupation:id,name,employee_unit_type_id',
                // 'employeeoccupation.employeeunitypeoccupation:id,name',
            ])->get();
    }
}