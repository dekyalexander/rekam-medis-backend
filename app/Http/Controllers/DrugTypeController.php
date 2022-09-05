<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrugTypeController extends Controller
{
    protected $DrugTypeService;

  public function __construct(DrugTypeService $DrugTypeService){
    $this->DrugTypeService = $DrugTypeService;
  }

  public function getDrugTypeOptions(Request $request){
    $filters=[
      'drug_type'=>$request->drug_type
    ];
    return $this->DrugTypeService->getDrugTypeOptions($filters);
  }

  // public function createDrugType(Request $request){
  //   try{
  //     $data = [
  //       'drug_type' => $request->drug_type,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
  //     $this->DrugTypeService->createDrugType($data);      
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create drug type']);
  //   }

  // }


  public function createDrugType(Request $request){
    DB::beginTransaction();
    try{
      $data = [
        'drug_type' => $request->drug_type,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $respon = $this->DrugTypeService->createDrugType($data);      
      if ($respon) {
        DB::commit();
        return response(['message'=>'success']);
      } else {
        return response()->json([
          'message' => 'Record already exist !.'], 500);
      }     

    }catch(\Exception $e){
      DB::rollback();
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug type']);
    }

  }



  public function updateDrugType(Request $request){
    try{
      $data = [
        'drug_type' => $request->drug_type,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
      $this->DrugTypeService->updateDrugType($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug type']);
    }
  }

  public function deleteDrugType(Request $request){
    try{      
      $this->DrugTypeService->deleteDrugType($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug type']);
    }
  }

}
