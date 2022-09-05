<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DiagnosisGeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiagnosisGeneralController extends Controller
{
    protected $DiagnosisGeneralService;

  public function __construct(DiagnosisGeneralService $DiagnosisGeneralService){
    $this->DiagnosisGeneralService = $DiagnosisGeneralService;
  }

  public function getDiagnosisGeneralOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name
    ];
    return $this->DiagnosisGeneralService->getDiagnosisGeneralOptions($filters);
  }

  // public function createDiagnosisGeneral(Request $request){
  //   try{
  //     $data = [
  //       'diagnosis_name' => $request->diagnosis_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DiagnosisGeneralService->createDiagnosisGeneral($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis general']);
  //   }

  // }

  public function createDiagnosisGeneral(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'diagnosis_kode'=>$request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DiagnosisGeneralService->createDiagnosisGeneral($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      } 

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis general']);
    }

  }

  public function updateDiagnosisGeneral(Request $request){
    try{
      $data = [
        'diagnosis_kode'=>$request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DiagnosisGeneralService->updateDiagnosisGeneral($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update diagnosis general']);
    }
  }

  public function deleteDiagnosisGeneral(Request $request){
    try{      
      $this->DiagnosisGeneralService->deleteDiagnosisGeneral($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete diagnosis general']);
    }
  }


}
