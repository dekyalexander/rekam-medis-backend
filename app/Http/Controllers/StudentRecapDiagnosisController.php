<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StudentRecapDiagnosisService;
use Illuminate\Http\Request;
use App\Exports\StudentTreatmentExcel;
use App\Exports\StudentMCUExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StudentRecapDiagnosisController extends Controller
{
    protected $StudentRecapDiagnosisService;

  public function __construct(StudentRecapDiagnosisService $StudentRecapDiagnosisService){
    $this->StudentRecapDiagnosisService = $StudentRecapDiagnosisService;
  }

  public function dataMCU(Request $request){
    $page = $request->page;
    $rowsPerPage = $request->rowsPerPage;

    if (!$rowsPerPage) {
      $rowsPerPage = 10;
    }

    try {
      $query = $this->StudentRecapDiagnosisService->dataMCU($request);

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

  public function dataTreatment(Request $request){
    $page = $request->page;
    $rowsPerPage = $request->rowsPerPage;

    if (!$rowsPerPage) {
      $rowsPerPage = 10;
    }

    try {
      $query = $this->StudentRecapDiagnosisService->dataTreatment($request);

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
		  return Excel::download(new StudentMCUExcel($request), 'student-mcu-recap-diagnosis.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
	}

  public function exportExcelTreatment(Request $request)
	{
    try {
		  return Excel::download(new StudentTreatmentExcel($request), 'student-treatment-recap-diagnosis.xlsx');
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
	}

}
