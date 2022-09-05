<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugUnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrugUnitController extends Controller
{
    protected $DrugUnitService;

  public function __construct(DrugUnitService $DrugUnitService){
    $this->DrugUnitService = $DrugUnitService;
  }

  public function getDrugUnitOptions(Request $request){
    $filters=[
      'drug_unit'=>$request->drug_unit,
      'created_at'=>$request->created_at
    ];
    return $this->DrugUnitService->getDrugUnitOptions($filters);
  }

  // public function createDrugUnit(Request $request){
  //   try{
  //     $data = [
  //       'drug_unit' => $request->drug_unit,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DrugUnitService->createDrugUnit($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create drug unit']);
  //   }

  // }


  public function createDrugUnit(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'drug_unit' => $request->drug_unit,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DrugUnitService->createDrugUnit($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      }     

    }catch(\Exception $e){
       DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug unit']);
    }

  }

  public function updateDrugUnit(Request $request){
    try{
      $data = [
        'drug_unit' => $request->drug_unit,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DrugUnitService->updateDrugUnit($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug unit']);
    }
  }

  public function deleteDrugUnit(Request $request){
    try{      
      $this->DrugUnitService->deleteDrugUnit($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug unit']);
    }
  }

}
