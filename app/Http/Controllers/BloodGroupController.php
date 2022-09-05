<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BloodGroupService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BloodGroupController extends Controller
{
    protected $BloodGroupService;

  public function __construct(BloodGroupservice $BloodGroupService){
    $this->BloodGroupService = $BloodGroupService;
  }

  public function getBloodGroupOptions(Request $request){
    $filters=[
      'blood_name'=>$request->blood_name
    ];
    return $this->BloodGroupService->getBloodGroupOptions($filters);
  }

}
