<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\KelasService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KelasController extends Controller{
  protected $kelasService;

  public function __construct(KelasService $kelasService){
    $this->kelasService = $kelasService;
  }

  public function getKelassByFilters(Request $request)
  {
    return $this->kelasService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  public function getKelasOptions(Request $request){
    $filters=[
      'school_id'=>$request->school_id,
      'jenjang_id'=>$request->jenjang_id,
    ];
    return $this->kelasService->getKelasOptions($filters);
  }

  public function syncKelas(Request $request){
    if(isset($request->jenjang_code)){
      if($request->jenjang_code==='TK'){
        $this->kelasService->syncKelasTK();      
      }elseif ($request->jenjang_code==='SD') {
        $this->kelasService->syncKelasSD();
      }elseif ($request->jenjang_code==='SMP') {
        $this->kelasService->syncKelasSMP();
      }elseif ($request->jenjang_code==='SMA') {
        $this->kelasService->syncKelasSMA();
      }elseif ($request->jenjang_code==='PCI') {
        $this->kelasService->syncKelasPCI();
      }
      return response(['message'=>'success']);

    }else{
      return response(['error' => 'no jenjang_code', 'message' => 'please input jenjang code']);
    }
  }

  public function createKelas(Request $request){
    try{
      $data = [
        'jenjang_id' => $request->jenjang_id,
        'school_id' => $request->school_id,
        'name' => $request->name,
        'code' => $request->code
      ];
      $this->kelasService->createKelas($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create kelas']);
    }

  }

  public function updateKelas(Request $request){
    try{
      $data = [
        'jenjang_id' => $request->jenjang_id,
        'school_id' => $request->school_id,
        'name' => $request->name,
        'code' => $request->code
      ];
      $this->kelasService->updateKelas($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update kelas']);
    }
  }

  public function deleteKelass(Request $request){
    try{      
      $this->kelasService->deleteKelass($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete kelas']);
    }
  }

  
}
