<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrugLocationController extends Controller
{
    protected $DrugLocationService;

  public function __construct(DrugLocationService $DrugLocationService){
    $this->DrugLocationService = $DrugLocationService;
  }

  public function getDrugLocationOptions(Request $request){
    $filters=[
      'id' => $request->id,
      'uks_name' => $request->uks_name,
    ];
    return $this->DrugLocationService->getDrugLocationOptions($filters);
  }

  // public function createDrugLocation(Request $request){
  //   try{
  //     $data = [
  //       'uks_name'=>$request->uks_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DrugLocationService->createDrugLocation($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create drug location']);
  //   }

  // }


  public function createDrugLocation(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'uks_name'=>$request->uks_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DrugLocationService->createDrugLocation($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      } 

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug location']);
    }

  }

  public function updateDrugLocation(Request $request){
    try{
      $data = [
        'uks_name'=>$request->uks_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DrugLocationService->updateDrugLocation($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug location']);
    }
  }

  public function deleteDrugLocation(Request $request){
    try{      
      $this->DrugLocationService->deleteDrugLocation($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug location']);
    }
  }

}
