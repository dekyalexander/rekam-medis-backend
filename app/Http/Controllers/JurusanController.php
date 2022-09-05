<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\JurusanService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JurusanController extends Controller{
  protected $jurusanService;

  public function __construct(JurusanService $jurusanService){
    $this->jurusanService = $jurusanService;
  }

  public function getJurusansByFilters(Request $request)
  {
    return $this->jurusanService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  public function getJurusanOptions(Request $request){
    return $this->jurusanService->getJurusanOptions($request->group);
  }

  public function syncJurusan(Request $request){
    if(isset($request->jenjang_code)){
      if($request->jenjang_code==='TK'){
        $this->jurusanService->syncJurusanTK();      
      }elseif ($request->jenjang_code==='SD') {
        $this->jurusanService->syncJurusanSD();
      }elseif ($request->jenjang_code==='SMP') {
        $this->jurusanService->syncJurusanSMP();
      }elseif ($request->jenjang_code==='SMA') {
        $this->jurusanService->syncJurusanSMA();
      }elseif ($request->jenjang_code==='PCI') {
        $this->jurusanService->syncJurusanPCI();
      }

      return response(['message'=>'success']);

    }else{
      return response(['error' => 'no jenjang_code', 'message' => 'please input jenjang code']);
    }
    
  }

  public function createJurusan(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'code' => $request->code,
        'jenjang_id' => $request->jenjang_id
      ];
      $this->jurusanService->createJurusan($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create jurusan']);
    }

  }

  public function updateJurusan(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'code' => $request->code,
        'jenjang_id' => $request->jenjang_id
      ];
      $this->jurusanService->updateJurusan($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update jurusan']);
    }
  }

  public function deleteJurusans(Request $request){
    try{      
      $this->jurusanService->deleteJurusans($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete jurusan']);
    }
  }

  
}
