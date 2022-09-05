<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EmployeeRecapDiagnosisService;
use Illuminate\Http\Request;
use App\Exports\EmployeeTreatmentExcel;
use App\Exports\EmployeeMCUExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\EmployeeMCU;

class EmployeeRecapDiagnosisController extends Controller
{
    protected $EmployeeRecapDiagnosisService;

  public function __construct(EmployeeRecapDiagnosisService $EmployeeRecapDiagnosisService){
    $this->EmployeeRecapDiagnosisService = $EmployeeRecapDiagnosisService;
  }

  public function dataTreatment(Request $request){
    $page = $request->page;
    $rowsPerPage = $request->rowsPerPage;

    if (!$rowsPerPage) {
      $rowsPerPage = 25;
    }

    try {
      $query = $this->EmployeeRecapDiagnosisService->dataTreatment($request);

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

  public function exportExcelTreatment(Request $request)
	{
    try {
		  return Excel::download(new EmployeeTreatmentExcel($request), 'employee-recap-diagnosis-treatment.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
	}


  public function dataMCU(Request $request){
    $page = $request->page;
    $rowsPerPage = $request->rowsPerPage;

    if (!$rowsPerPage) {
      $rowsPerPage = 25;
    }

    try {
      $query = $this->EmployeeRecapDiagnosisService->dataMCU($request);

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

  public function exportExcelMCU(Request $request)
	{
    try {
		  return Excel::download(new EmployeeMCUExcel($request), 'employee-recap-diagnosis-mcu.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
    
	}

}
