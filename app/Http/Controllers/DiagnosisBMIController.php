<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DiagnosisBMIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiagnosisBMIController extends Controller
{
    protected $DiagnosisBMIService;

  public function __construct(DiagnosisBMIservice $DiagnosisBMIService){
    $this->DiagnosisBMIService = $DiagnosisBMIService;
  }

  public function getDiagnosisBMIOptions(Request $request){
    $filters=[
      'diagnosis_name'=>$request->diagnosis_name
    ];
    return $this->DiagnosisBMIService->getDiagnosisBMIOptions($filters);
  }

  // public function createDiagnosisBMI(Request $request){
  //   try{
  //     $data = [
  //       'diagnosis_kode' => $request->diagnosis_kode,
  //       'diagnosis_name' => $request->diagnosis_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DiagnosisBMIService->createDiagnosisBMI($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis bmi']);
  //   }

  // }


  public function createDiagnosisBMI(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'diagnosis_kode' => $request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DiagnosisBMIService->createDiagnosisBMI($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      } 

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create diagnosis bmi']);
    }

  }

  public function updateDiagnosisBMI(Request $request){
    try{
      $data = [
        'diagnosis_kode' => $request->diagnosis_kode,
        'diagnosis_name' => $request->diagnosis_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DiagnosisBMIService->updateDiagnosisBMI($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update diagnosis bmi']);
    }
  }

  public function deleteDiagnosisBMI(Request $request){
    try{      
      $this->DiagnosisBMIService->deleteDiagnosisBMI($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete diagnosis bmi']);
    }
  }

}
