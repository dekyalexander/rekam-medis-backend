<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ParentService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParentController extends Controller{
  protected $parentService;

  public function __construct(ParentService $parentService){
    $this->parentService = $parentService;
  }

  public function getParentsByFilters(Request $request)
  {
    $filters=[
      'keyword'=>$request->keyword,
      'parent_id'=>$request->parent_id,
      'student_id'=>$request->student_id
    ];
    return $this->parentService->getByFiltersPagination($filters, $request->rowsPerPage);
  }

  public function getParentOptions(Request $request){
    $filters=[
      'name'=>$request->name,
      'parent_id'=>$request->parent_id
    ];
    return $this->parentService->getParentOptions($filters);
  }

  public function getStudentsOfParent(Request $request){    
    return $this->parentService->getStudentsOfParent($request->parent_id);
  }

  public function getParentDetail($parent_id){
    return $this->parentService->getParentDetail($parent_id);
  }

  public function addStudentsToParent(Request $request){    
    return $this->parentService->addStudentsToParent($request->parent_id, $request->sex_type_value, $request->student_ids);
  }

  public function createParent(Request $request){    	
    try{
      $data = [
        'user_id' => $request->user_id,
        'name' => $request->name,
        'mobilePhone' => $request->mobilePhone,
        'sex_type_value' => $request->sex_type_value,
        'ktp' => $request->ktp,
        'nkk' => $request->nkk,
        'email' => $request->email,
        'birth_date' => $request->birth_date,
        'parent_type_value' => $request->parent_type_value,
        'wali_type_value' => $request->wali_type_value,
        'job' => $request->job,
        'jobCorporateName' => $request->jobCorporateName,
        'jobPositionName' => $request->jobPositionName,
        'jobWorkAddress' => $request->jobWorkAddress,
        'address' => $request->address,        
        'provinsi_id' => $request->provinsi_id,
        'kota_id' => $request->kota_id,
        'kecamatan_id' => $request->kecamatan_id,
        'kelurahan_id' => $request->kelurahan_id,
        'created_at'=>  Carbon::now()
      ];
      $this->parentService->createParent($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create parent']);
    }

  }

  public function updateParent(Request $request){
    try{
      $data = [
        'user_id' => $request->user_id,
        'name' => $request->name,
        'mobilePhone' => $request->mobilePhone,
        'sex_type_value' => $request->sex_type_value,
        'ktp' => $request->ktp,
        'nkk' => $request->nkk,
        'email' => $request->email,
        'birth_date' => $request->birth_date,
        'parent_type_value' => $request->parent_type_value,
        'wali_type_value' => $request->wali_type_value,
        'job' => $request->job,
        'jobCorporateName' => $request->jobCorporateName,
        'jobPositionName' => $request->jobPositionName,
        'jobWorkAddress' => $request->jobWorkAddress,
        'address' => $request->address,        
        'provinsi_id' => $request->provinsi_id,
        'kota_id' => $request->kota_id,
        'kecamatan_id' => $request->kecamatan_id,
        'kelurahan_id' => $request->kelurahan_id,
        'updated_at'=>  Carbon::now()
      ];
      $this->parentService->updateParent($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update parent']);
    }
  }

  public function deleteParents(Request $request){
    try{      
      $this->parentService->deleteParents($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete parent']);
    }
  }

  
}
