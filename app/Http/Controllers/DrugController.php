<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugService;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Validator;
use App\Exports\DrugRecapInExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DrugController extends Controller
{
    protected $DrugService;

  public function __construct(DrugService $DrugService){
    $this->DrugService = $DrugService;
  }

  public function export(Request $request)
	{
    try {
		  return Excel::download(new DrugRecapInExcel($request), 'recap-drug-in.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
	}

  // public function getListUKSLocationOptions(Request $request){
  //   $filters=[
  //     'uks_name'=>$request->uks_name
  //   ];
  //   return $this->DrugService->getListUKSLocationOptions($filters);
  // }

  // public function getLocationDrugOptions(Request $request){
  //   $filters=[
  //     'uks_name' => $request->uks_name,
  //   ];
  //   return $this->DrugService->getLocationDrugOptions($filters);
  // }

  public function getDrugDistributionOptions(Request $request){
    $filters=[
      'drug_type_id' => $request->drug_type_id,
      'location_id' => $request->location_id,
      'drug_id' => $request->drug_id,
      'drug_name_id' => $request->drug_name_id,
      'created_at'=>$request->created_at,
      'updated_at'=>$request->updated_at
    ];
    return $this->DrugService->getDrugDistributionOptions($filters);
  }

   public function getDrugDistributionSettings(Request $request){
    $filters=[
      'drug_type_id' => $request->drug_type_id,
      'location_id' => $request->location_id,
      'keyword'=>$request->keyword,
      'created_at'=>$request->created_at,
      'updated_at'=>$request->updated_at
    ];
    return $this->DrugService->getDrugDistributionSettings($filters);
  }

  public function getDrugOptions(Request $request){
    $filters=[
      'drug_type_id' => $request->drug_type_id,
      'location_id' => $request->location_id,
      'keyword'=>$request->keyword,
      'created_at'=>$request->created_at,
      'updated_at'=>$request->updated_at
    ];
    return $this->DrugService->getDrugOptions($filters);
  }

  public function createDrug(Request $request){
    try{
      $data_drug_name = [
        'description' => $request->description,
        'drug_name_id' => $request->drug_name_id,
        'drug_unit_id' => $request->drug_unit_id,
        'drug_type_id' => $request->drug_type_id,
        'location_id' => $request->location_id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $lastdrugId = $this->DrugService->createDataDrug($data_drug_name);

      //echo var_dump($lastdrugId);

       $data_expired_drug = [
        'date_expired' => $request->date_expired,
        'drug_id' => $lastdrugId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $lastexpiredId = $this->DrugService->createDataExpiredDrug($data_expired_drug);

      //$this->DrugService->createDataExpiredDrug($data_expired_drug);

      //echo var_dump($lastexpiredId);

      $data_location_drug = [
        'location_id' => $request->location_id,
        'drug_id' => $lastdrugId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $lastlocationId = $this->DrugService->createDataLocationDrug($data_location_drug);

      //$this->DrugService->createDataLocationDrug($data_location_drug);

      //echo var_dump($lastlocationId);

      $data_stock_drug = [
        'qty' => $request->qty,
        'drug_id' => $lastdrugId,
        'location_id' => $lastlocationId,
        'drug_expired_id' => $lastexpiredId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
     
      $this->DrugService->createDataStockDrug($data_stock_drug);

      $data_distribution_drug = [
	'drug_id' => $lastdrugId,
        'location_id' => $request->location_id,
        'drug_name_id' => $request->drug_name_id,
        'drug_unit_id' => $request->drug_unit_id,
        'drug_type_id' => $request->drug_type_id,
        'drug_expired_id' => $lastexpiredId,
        'description' => $request->description,
        'qty' => $request->qty,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];
     
      $this->DrugService->createDataDistributionDrug($data_distribution_drug);

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug']);
    }
  }


  public function createDrugDistributionSettings(Request $request){
    try{
      $data_distribution_drug = [
        'location_id' => $request->location_id,
        'drug_name_id' => $request->drug_name_id,
        'drug_unit_id' => $request->drug_unit_id,
        'drug_type_id' => $request->drug_type_id,
        'drug_expired_id' => $lastexpiredId,
        'description' => $request->description,
        'qty' => $request->qty,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->createDrugDistributionSettings($data_distribution_drug);

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create drug distribution']);
    }
  }


  // public function createDrug(Request $request){
  //   DB::beginTransaction();
  //   try{
  //     $data_drug_name = [
  //       'description' => $request->description,
  //       'drug_name_id' => $request->drug_name_id,
  //       'drug_unit_id' => $request->drug_unit_id,
  //       'drug_type_id' => $request->drug_type_id,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $lastdrugId = $this->DrugService->createDataDrug($data_drug_name);

  //     //echo var_dump($lastdrugId);

  //      $data_expired_drug = [
  //       'date_expired' => $request->date_expired,
  //       'drug_id' => $lastdrugId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $lastexpiredId = $this->DrugService->createDataExpiredDrug($data_expired_drug);

  //     //$this->DrugService->createDataExpiredDrug($data_expired_drug);

  //     //echo var_dump($lastexpiredId);

  //     $data_location_drug = [
  //       'location_name' => $request->location_name,
  //       'drug_id' => $lastdrugId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $lastlocationId = $this->DrugService->createDataLocationDrug($data_location_drug);

  //     //$this->DrugService->createDataLocationDrug($data_location_drug);

  //     //echo var_dump($lastlocationId);

  //     $data_stock_drug = [
  //       'qty' => $request->qty,
  //       'drug_id' => $lastdrugId,
  //       'location_id' => $lastlocationId,
  //       'drug_expired_id' => $lastexpiredId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
     
  //     $this->DrugService->createDataStockDrug($data_stock_drug);     
  //     if ($lastdrugId) {
  //       DB::commit();
  //       return response(['message'=>'success']);
  //     } else {
  //       return response()->json([
  //         'message' => 'Record already exist !.'], 500);
  //     }     

  //   }catch(\Exception $e){
  //     DB::rollback();
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed create drug']);
  //   }
  // }

  public function updateDrug(Request $request){
    try{
      $data_drug_name = [
        'description' => $request->description,
        'drug_name_id' => $request->drug_name_id,
        'drug_unit_id' => $request->drug_unit_id,
        'drug_type_id' => $request->drug_type_id,
        'location_id' => $request->location_id,
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->updateData($data_drug_name, $request->id);

       $data_expired_drug = [
        'date_expired' => $request->date_expired,
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->updateData2($data_expired_drug, $request->id);

      $data_location_drug = [
        'location_id' => $request->location_id,
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->updateData3($data_location_drug, $request->id);

      $data_stock_drug = [
        'qty' => $request->qty,
        'updated_at' => Carbon::now()
      ];
     
      $this->DrugService->updateData4($data_stock_drug, $request->id);

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug']);
    }
  }


  public function updateDrugDistributionSettings(Request $request){
    try{
      $data_drug_distribution = [
        'location_id' => $request->location_id,
        'drug_name_id' => $request->drug_name_id,
        'drug_unit_id' => $request->drug_unit_id,
        'drug_type_id' => $request->drug_type_id,
        'description' => $request->description,
        'qty' => $request->qty,
        'updated_at' => Carbon::now()
      ];

      $this->DrugService->updateDrugDistributionSettings($data_drug_distribution, $request->id);


      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update drug distribution']);
    }
  }

  // public function updateDrug(Request $request){
  //   try{
  //     $data_drug_name = [
  //       'description' => $request->description,
  //       'drug_name_id' => $request->drug_name_id,
  //       'drug_unit_id' => $request->drug_unit_id,
  //       'drug_type_id' => $request->drug_type_id,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $this->DrugService->updateDataDrug($data_drug_name, $request->id);

  //     //echo var_dump($lastdrugId);

  //      $data_expired_drug = [
  //       'date_expired' => $request->date_expired,
  //       //'drug_id' => $lastdrugId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $this->DrugService->updateDataExpiredDrug($data_expired_drug, $request->id);

  //     //echo var_dump($lastexpiredId);

  //     $data_location_drug = [
  //       'location_name' => $request->location_name,
  //       //'drug_id' => $lastdrugId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];

  //     $this->DrugService->updateDataLocationDrug($data_location_drug, $request->id);

  //     //echo var_dump($lastlocationId);

  //     $data_stock_drug = [
  //       'qty' => $request->qty,
  //       //'drug_id' => $lastdrugId,
  //       //'location_id' => $lastlocationId,
  //       //'drug_expired_id' => $lastexpiredId,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ];
     
  //     $this->DrugService->updateDataStockDrug($data_stock_drug, $request->id);     
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed update drug']);
  //   }
  // }

  // public function updateDrug(Request $request){
  //   try{
  //   $data = [
  //     'drug' => [
  //       'description' => $request->description,
  //       'drug_name_id' => $request->drug_name_id,
  //       'drug_unit_id' => $request->drug_unit_id,
  //       'drug_type_id' => $request->drug_type_id,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ],
  //     'drug_expired' => [
  //       'date_expired' => $request->date_expired,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ],
  //     'location_drug' => [
  //       'location_name' => $request->location_name,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ],
  //     'stock' => [
  //       'qty' => $request->qty,
  //       'created_at' => Carbon::now(),
  //       'updated_at' => Carbon::now()
  //     ],
  //   ];

  //     $this->DrugService->updateDataDrug($data, $request->id);   
  //     return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed update drug']);
  //   }
  // }
  public function deleteDrug(Request $request){
    try{      
      $this->DrugService->deleteDrug($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug']);
    }
  }

   public function deleteDrugDistributionSettings(Request $request){
    try{      
      $this->DrugService->deleteDrugDistributionSettings($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete drug distribution']);
    }
  }


}
