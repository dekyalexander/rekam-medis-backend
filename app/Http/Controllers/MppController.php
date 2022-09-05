<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\MppService;
use Exception;

class MppController extends Controller
{

    public $success = 200;
    public $unauth = 401;
    public $error = 500;
    public $conflict = 409;
  
    protected $mppService;
  
    public function __construct(MppService $mppService)
    {
      $this->mppService = $mppService;
    }

    public function getData(Request $request)
    {

      $requestParams = $request->all();
      $rowsPerPage = $request->rowsPerPage;
      $page = $request->page;
  
      if (!$rowsPerPage) {
        $rowsPerPage = 10;
      }

      try {
        $result = $this->mppService->getData( $requestParams, $rowsPerPage , $page );
  
        // return response()->json(['data' => $result,'status' => $this->success]);
        return response($result);

      } catch (\Exception $e) {
        // return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
        $result = [
          'error' => $e->getMessage(),
          'status' => $this->error,
          'message' => 'failed get data',
        ];
        return response($result);
      }


    }

    public function store(Request $request)
    {
      $data = $request->only([
        'tahun_pelajaran',
        'validity_period_from',
        'validity_period_until',
        'description_1',
        'publish',
        'user_created_id',
      ]);

      $result = ['status' => 201];

      $result = $this->mppService->store($data);
  
      if ($result) {
        return response()->json(['message' => 'stored data', 'status' => $this->success, 'data' => $data]);
      } else {
        return response()->json(['errors' => ['store' => 'stored failed'], 'status' => $this->error]);
      }
    }

    public function update(Request $request)
    {

      $data = $request->only([
        'tahun_pelajaran',
        'validity_period_from',
        'validity_period_until',
        'description_1',
        'publish',
        'user_created_id',
      ]);

      $result = ['status' => 201];
      $id = $request->id;
      $result = $this->mppService->update($data, $id);
  
      if ($result) {
        return response()->json(['message' => 'changed data'], $this->success);
      } else {
        return response()->json(['errors' => ['update' => 'change failed']], $this->error);
      }
    }



}
