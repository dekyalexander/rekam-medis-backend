<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DiagnosisEyesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiagnosisEyesController extends Controller
{
    protected $DiagnosisEyesService;

  public function __construct(DiagnosisEyesservice $DiagnosisEyesService){
    $this->DiagnosisEyesService = $DiagnosisEyesService;
  }

  public function getDiagnosisEyesOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name
    ];
    return $this->DiagnosisEyesService->getDiagnosisEyesOptions($filters);
  }

  // public function createDiagnosisEyes(Request $request){
  //   try{
  //     $data = [
  //       'diagnosis_kode' => $request->diagnosis_kode,
  //       'diagnosis_name' => $request->diagnosis_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DiagnosisEyesService->createDiagnosisEyes($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis eyes']);
  //   }

  // }


  public function createDiagnosisEyes(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'diagnosis_kode' => $request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DiagnosisEyesService->createDiagnosisEyes($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      } 

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis eyes']);
    }

  }

  public function updateDiagnosisEyes(Request $request){
    try{
      $data = [
        'diagnosis_kode' => $request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DiagnosisEyesService->updateDiagnosisEyes($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update diagnosis eyes']);
    }
  }

  public function deleteDiagnosisEyes(Request $request){
    try{      
      $this->DiagnosisEyesService->deleteDiagnosisEyes($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete diagnosis eyes']);
    }
  }

}
