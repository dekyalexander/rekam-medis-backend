<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SchoolService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchoolController extends Controller{
  protected $schoolService;

  public function __construct(SchoolService $schoolService){
    $this->schoolService = $schoolService;
  }

  public function getSchoolsByFilters(Request $request)
  {
    return $this->schoolService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  public function getSchoolOptions(Request $request){
    $filters=[
      'jenjang_id'=>$request->jenjang_id
    ];
    return $this->schoolService->getSchoolOptions($filters);
  }

  public function createSchool(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'code' => $request->code,
        'jenjang_id' => $request->jenjang_id,
        'head_employee_id' => $request->head_employee_id,
        'created_at'=>  Carbon::now()
      ];
      $this->schoolService->createSchool($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create school']);
    }

  }

  public function updateSchool(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'code' => $request->code,
        'jenjang_id' => $request->jenjang_id,
        'head_employee_id' => $request->head_employee_id,
        'updated_at'=>  Carbon::now()
      ];
      $this->schoolService->updateSchool($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update school']);
    }
  }

  public function deleteSchools(Request $request){
    try{      
      $this->schoolService->deleteSchools($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete school']);
    }
  }

  
}
