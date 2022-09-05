<?php

namespace App\Services;
use App\Repositories\DrugRecapRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugRecapService{
    protected $drugrecapRepository;

    public function __construct(DrugRecapRepository $drugrecapRepository){
	    $this->drugrecapRepository = $drugrecapRepository;
    }

    // public function getDrugRecapOptions($filters){
	//     return $this->drugrecapRepository->getDrugRecapOptions($filters)->get();
    // }

    public function getDrugRecapOptions($request){
    $result = $this->drugrecapRepository->getDrugRecapOptions($request);
    return $result;
    }
        
}
