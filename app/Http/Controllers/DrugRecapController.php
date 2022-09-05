<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DrugRecapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\DrugRecapOutExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DrugRecapController extends Controller
{
    protected $DrugRecapService;

  public function __construct(DrugRecapservice $DrugRecapService){
    $this->DrugRecapService = $DrugRecapService;
  }

  public function getDrugRecapOptions(Request $request){
    $page = $request->page;
    $rowsPerPage = $request->rowsPerPage;

    if (!$rowsPerPage) {
      $rowsPerPage = 10;
    }

    try {
      $query = $this->DrugRecapService->getDrugRecapOptions($request);

      if ($request->page) {
        $result = $query->paginate($rowsPerPage);
      } else {
        $result = $query->get();
      }

      return response($result);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }

  public function export(Request $request)
	{
    try {
		  return Excel::download(new DrugRecapOutExcel($request), 'recap-of-remaining-drug.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
	}

}
