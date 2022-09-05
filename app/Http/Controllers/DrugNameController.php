<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugNameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrugNameController extends Controller
{
    protected $DrugNameService;

  public function __construct(DrugNameService $DrugNameService){
    $this->DrugNameService = $DrugNameService;
  }

  public function getDrugNameOptions(Request $request){
    $filters=[
      'id'=>$request->id,
      'drug_kode'=>$request->drug_kode,
      'drug_name'=>$request->drug_name,
      'created_at'=>$request->created_at,
    ];
    return $this->DrugNameService->getDrugNameOptions($filters);
  }

  // public function createDrugName(Request $request){
  //   try{
  //     $data = [
  //       'drug_kode' => $request->drug_kode,
  //       'drug_name' => $request->drug_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DrugNameService->createDrugName($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create drug name']);
  //   }

  // }

  public function createDrugName(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'drug_kode' => $request->drug_kode,
        'drug_name' => $request->drug_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DrugNameService->createDrugName($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      }     

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug name']);
    }

  }

  public function updateDrugName(Request $request){
    try{
      $data = [
        'drug_kode' => $request->drug_kode,
        'drug_name' => $request->drug_name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DrugNameService->updateDrugName($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug name']);
    }
  }

  public function deleteDrugName(Request $request){
    try{      
      $this->DrugNameService->deleteDrugName($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug name']);
    }
  }

}
