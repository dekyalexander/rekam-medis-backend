<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TahunPelajaranService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TahunPelajaranController extends Controller{
  protected $tahunPelajaranService;

  public function __construct(TahunPelajaranService $tahunPelajaranService){
    $this->tahunPelajaranService = $tahunPelajaranService;
  }

  public function getTahunPelajaransByFilters(Request $request)
  {
    return $this->tahunPelajaranService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  public function getTahunPelajaranOptions(Request $request){
    return $this->tahunPelajaranService->getTahunPelajaranOptions($request->group);
  }

  public function createTahunPelajaran(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'is_active' => $request->is_active,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'created_at'=>  Carbon::now()
      ];
      $this->tahunPelajaranService->createTahunPelajaran($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create tahunPelajaran']);
    }

  }

  public function updateTahunPelajaran(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'is_active' => $request->is_active,
        'updated_at'=>  Carbon::now()
      ];
      $this->tahunPelajaranService->updateTahunPelajaran($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update tahunPelajaran']);
    }
  }

  public function deleteTahunPelajarans(Request $request){
    try{      
      $this->tahunPelajaranService->deleteTahunPelajarans($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete tahunPelajaran']);
    }
  }

  
}
