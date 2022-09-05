<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\JenjangService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JenjangController extends Controller{
  protected $jenjangService;

  public function __construct(JenjangService $jenjangService){
    $this->jenjangService = $jenjangService;
  }

  public function getJenjangsByFilters(Request $request)
  {
    return $this->jenjangService->getByFiltersPagination($request->all(), $request->rowsPerPage);
  }

  public function getJenjangOptions(Request $request){
    return $this->jenjangService->getJenjangOptions($request->group);
  }

  public function createJenjang(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'code' => $request->code
      ];
      $this->jenjangService->createJenjang($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create jenjang']);
    }

  }

  public function updateJenjang(Request $request){
    try{
      $data = [
        'name' => $request->name,
        'code' => $request->code
      ];
      $this->jenjangService->updateJenjang($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update jenjang']);
    }
  }

  public function deleteJenjangs(Request $request){
    try{      
      $this->jenjangService->deleteJenjangs($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete jenjang']);
    }
  }

  
}
