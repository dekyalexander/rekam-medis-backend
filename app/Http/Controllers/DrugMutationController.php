<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugMutationService;
use App\Services\DrugService;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Exports\DrugRecapMutationExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\DrugDistribution;

class DrugMutationController extends Controller
{
    protected $DrugMutationService;

  public function __construct(DrugMutationService $DrugMutationService, DrugService $DrugService){
    $this->DrugMutationService = $DrugMutationService;
    $this->DrugService = $DrugService;
  }

  // public function getDrugMutationOptions(Request $request){
  //   $filters=[
  //     'drug_id' => $request->drug_id,
  //     'location_id' => $request->location_id,
  //     'drug_expired_id' => $request->drug_expired_id,
  //     'qty' => $request->qty,
  //     'created_at'=>$request->created_at
  //   ];
  //   return $this->DrugMutationService->getDrugMutationOptions($filters);
  // }

  public function getDrugMutationOptions(Request $request){
     $filters=[
      'drug_type_id' => $request->drug_type_id,
      'location_id' => $request->location_id,
      'drug_id' => $request->drug_id,
      'drug_name_id' => $request->drug_name_id,
      'keyword'=>$request->keyword,
      'created_at'=>$request->created_at,
      'updated_at'=>$request->updated_at
    ];
    return $this->DrugMutationService->getDrugMutationOptions($filters);
  }

  public function export(Request $request)
	{
    try {
		  return Excel::download(new DrugRecapMutationExcel($request), 'recap-drug-mutation.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
	}

  public function createDrugMutation(Request $request){
    try{
      $data_drug = [
        'drug_id' => $request->drug_id,
        'location_id' => $request->location_id,
        'drug_expired_id' => $request->drug_expired_id,
        'qty' => $request->qty,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->DrugMutationService->createDataDrugMutation($data_drug);
     
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug mutation']);
    }
  }
  public function updateDrugMutation(Request $request){
    try{
     $row =  json_decode($request->statetransferto, true);

    $data_drug = [
      'qty' => $request->qty,
      'updated_at' => Carbon::now()
    ];

    $this->DrugMutationService->updateDataDrugMutation($data_drug, $request->id);

    
      $drug_distribution_id = $row['drug_distribution_id'];
      $qty_mutation = $row['qty_mutation'];
      $qty_cek = $row['qty'] + $qty_mutation;
      $qty = $qty_cek; 


      // Update Jumlah Stok Yang Di Ambil Dari Obat Distribusi

      $data_drug_distribution = [
        'qty' => $qty,
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->updateDrugDistributionSettings($data_drug_distribution, $drug_distribution_id);

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug mutation']);
    }
  }
  public function deleteDrugMutation(Request $request){
    try{      
      $this->DrugMutationService->deleteDrugMutation($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug mutation']);
    }
  }


}
