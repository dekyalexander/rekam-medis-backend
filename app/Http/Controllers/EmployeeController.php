<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller{
  protected $employeeService;

  public function __construct(EmployeeService $employeeService){
    $this->employeeService = $employeeService;
  }

  public function getEmployeesByFilters(Request $request)
  {
    return $this->employeeService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  // public function getEmployeeOptions(Request $request){    
  //   return $this->employeeService->getEmployeeOptions($request->keyword);
  // }

   public function getEmployeeOptions(Request $request){  
     $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id, 
      'name'=>$request->name
    ];  
    return $this->employeeService->getEmployeeOptions($filters);
  }

  public function createEmployee(Request $request){
    try{
      $data = [
        'user_id' => $request->user_id,
        'stores_id' => $request->stores_id,
        'name' => $request->name,
        'mobilePhone' => $request->mobilePhone,
        'sex_type_value' => $request->sex_type_value,
        'nik' => $request->nik,
        'employee_type_value' => $request->employee_type_value,
        'is_active' => $request->is_active,
        'birth_date' => $request->birth_date,
        'joinDate' => $request->joinDate,
        'resignDate' => $request->resignDate,
        'created_at'=>  Carbon::now()
      ];
      $this->employeeService->createEmployee($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create employee']);
    }

  }

  public function updateEmployee(Request $request){
    try{
      $data = [
        'user_id' => $request->user_id,
        'stores_id' => $request->stores_id,
        'name' => $request->name,
        'mobilePhone' => $request->mobilePhone,
        'sex_type_value' => $request->sex_type_value,
        'nik' => $request->nik,
        'employee_type_value' => $request->employee_type_value,
        'is_active' => $request->is_active,
        'birth_date' => $request->birth_date,
        'joinDate' => $request->joinDate,
        'resignDate' => $request->resignDate,
        'updated_at'=>  Carbon::now()
      ];
      $this->employeeService->updateEmployee($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update employee']);
    }
  }

  public function deleteEmployees(Request $request){
    try{      
      $this->employeeService->deleteEmployees($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete employee']);
    }
  }

  
}
