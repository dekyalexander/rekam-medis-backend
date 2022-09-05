<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UKSOfficerRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UKSOfficerRegistrationController extends Controller{
  protected $UKSOfficerRegistrationService;

  public function __construct(UKSOfficerRegistrationService $UKSOfficerRegistrationService){
    $this->UKSOfficerRegistrationService = $UKSOfficerRegistrationService;
  }

  public function getListUKSLocationOptions(Request $request){
    $filters=[
      'uks_name'=>$request->uks_name
    ];
    return $this->UKSOfficerRegistrationService->getListUKSLocationOptions($filters);
  }

  public function getUKSOfficerRegistrationOptions(Request $request){
    $filters=[
      'name'=>$request->name,
      'keyword'=>$request->keyword,
      'job_location_id'=>$request->job_location_id,
      'created_at'=>$request->created_at
    ];
    return $this->UKSOfficerRegistrationService->getUKSOfficerRegistrationOptions($filters);
  }

  public function createUKSOfficerRegistration(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'job_location_id' => $request->job_location_id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->UKSOfficerRegistrationService->createUKSOfficerRegistration($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create uks officer registration']);
    }

  }

  // public function createUKSOfficerRegistration(Request $request){
  //   DB::beginTransaction();
  //   try{
  //     $data = [
  //       'name' => $request->name,
  //       'job_location_id' => $request->job_location_id,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $respon = $this->UKSOfficerRegistrationService->createUKSOfficerRegistration($data);      
  //     if ($respon) {
  //       DB::commit();
  //       return response(['message'=>'success']);
  //     } else {
  //       return response()->json([
  //         'message' => 'Record already exist !.'], 500);
  //     } 

  //   }catch(\Exception $e){
  //      DB::rollback();
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create uks officer registration']);
  //   }

  // }

  public function updateUKSOfficerRegistration(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'job_location_id' => $request->job_location_id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->UKSOfficerRegistrationService->updateUKSOfficerRegistration($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update uks officer registration']);
    }
  }

  public function deleteUKSOfficerRegistration(Request $request){
    try{      
      $this->UKSOfficerRegistrationService->deleteUKSOfficerRegistration($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete uks officer registration']);
    }
  }

}
