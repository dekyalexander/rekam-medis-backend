<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ParallelService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParallelController extends Controller{
  protected $parallelService;

  public function __construct(ParallelService $parallelService){
    $this->parallelService = $parallelService;
  }

  public function getParallelsByFilters(Request $request)
  {
    return $this->parallelService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  public function getParallelOptions(Request $request){
    $filters=[
      'kelas_id'=>$request->kelas_id
    ];
    return $this->parallelService->getParallelOptions($filters);
  }


  public function syncParallel(Request $request){
    if(isset($request->jenjang_code)){
      if($request->jenjang_code==='TK'){
        $this->parallelService->syncParallelTK();      
      }elseif ($request->jenjang_code==='SD') {
        $this->parallelService->syncParallelSD();
      }elseif ($request->jenjang_code==='SMP') {
        $this->parallelService->syncParallelSMP();
      }elseif ($request->jenjang_code==='SMA') {
        return $this->parallelService->syncParallelSMA();
      }elseif ($request->jenjang_code==='PCI') {
        $this->parallelService->syncParallelPCI();
      }

      return response(['message'=>'success']);

    }else{
      return response(['error' => 'no jenjang_code', 'message' => 'please input jenjang code']);
    }
    
  }

  public function createParallel(Request $request){
    try{
      $data = [
        'jenjang_id' => $request->jenjang_id,
        'school_id' => $request->school_id,
        'kelas_id' => $request->kelas_id,
        'jurusan_id' => $request->jurusan_id,
        'name' => $request->name,
        'code' => $request->code,
        'created_at'=>  Carbon::now()
      ];
      $this->parallelService->createParallel($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create parallel']);
    }

  }

  public function updateParallel(Request $request){
    try{
      $data = [
        'jenjang_id' => $request->jenjang_id,
        'school_id' => $request->school_id,
        'kelas_id' => $request->kelas_id,
        'jurusan_id' => $request->jurusan_id,
        'name' => $request->name,
        'code' => $request->code,
        'updated_at'=>  Carbon::now()
      ];
      $this->parallelService->updateParallel($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update parallel']);
    }
  }

  public function deleteParallels(Request $request){
    try{      
      $this->parallelService->deleteParallels($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete parallel']);
    }
  }

  
}
