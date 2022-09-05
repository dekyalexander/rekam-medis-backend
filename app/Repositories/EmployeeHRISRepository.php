<?php

namespace App\Repositories;

use App\Models\EmployeeHRIS;

class EmployeeHRISRepository
{
    protected $employeeHris;

    public function __construct(EmployeeHRIS $employeeHris)
    {
        $this->employeeHris = $employeeHris;
    }

    public function getUserIdByUsername($username)
    {
        return $this->employeeHris
            ->where('nik', $username)->pluck('id')->first();
    }
}