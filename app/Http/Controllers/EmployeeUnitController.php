<?php

namespace App\Http\Controllers;

use App\Services\EmployeeUnitService;
use Illuminate\Http\Request;

class EmployeeUnitController extends Controller
{
    protected $employeeUnitService;
    
    public function __construct(EmployeeUnitService $employeeUnitService)
    {
        $this->employeeUnitService = $employeeUnitService;
    }

    public function index(Request $request){
        return $this->employeeUnitService->getData($request);
    }
    
    public function option(Request $request)
    {
       
         return $this->employeeUnitService->getOption($request);
        /*        
            if($request->unit_type != 'all')
                $data = [0 => ['value'=>'all','label'=>'All']] + $data->all();    
        */
    }
}