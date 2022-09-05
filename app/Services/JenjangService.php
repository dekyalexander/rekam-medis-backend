<?php

namespace App\Services;
use App\Repositories\JenjangRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class JenjangService{
    protected $jenjangRepository;

    public function __construct(JenjangRepository $jenjangRepository){
	    $this->jenjangRepository = $jenjangRepository;
    }

    public function getJenjangsByFilters($filters){
	    return $this->jenjangRepository
      ->getJenjangsByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->jenjangRepository
      ->getJenjangsByFilters($filters)
      ->paginate($rowsPerPage);
    }

    public function getJenjangOptions($filters){
	    return $this->jenjangRepository->getJenjangOptions($filters)->get();
    }

    public function createJenjang($data){
      $this->jenjangRepository->insertJenjang($data);
  	}

    public function updateJenjang($data, $id){
      $this->jenjangRepository->updateJenjang($data, $id);
    }

    public function deleteJenjangs($ids){
      $this->jenjangRepository->deleteJenjangs($ids);          
    }
 
        
}
