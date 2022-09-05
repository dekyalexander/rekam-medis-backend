<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DiagnosisMCUService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiagnosisMCUController extends Controller
{
    protected $DiagnosisMCUService;

  public function __construct(DiagnosisMCUService $DiagnosisMCUService){
    $this->DiagnosisMCUService = $DiagnosisMCUService;
  }

  public function getDiagnosisMCUOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name
    ];
    return $this->DiagnosisMCUService->getDiagnosisMCUOptions($filters);
  }

  // public function createDiagnosisMCU(Request $request){
  //   try{
  //     $data = [
  //       'diagnosis_kode'=>$request->diagnosis_kode,
  //       'diagnosis_name' => $request->diagnosis_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DiagnosisMCUService->createDiagnosisMCU($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis mcu']);
  //   }

  // }

  public function createDiagnosisMCU(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'diagnosis_kode'=>$request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DiagnosisMCUService->createDiagnosisMCU($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      } 

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis mcu']);
    }

  }

  public function updateDiagnosisMCU(Request $request){
    try{
      $data = [
        'diagnosis_kode' => $request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DiagnosisMCUService->updateDiagnosisMCU($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update diagnosis mcu']);
    }
  }

  public function deleteDiagnosisMCU(Request $request){
    try{      
      $this->DiagnosisMCUService->deleteDiagnosisMCU($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete diagnosis mcu']);
    }
  }

}
