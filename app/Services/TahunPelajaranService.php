<?php

namespace App\Services;
use App\Repositories\TahunPelajaranRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class TahunPelajaranService{
    protected $tahunPelajaranRepository;

    public function __construct(TahunPelajaranRepository $tahunPelajaranRepository){
	    $this->tahunPelajaranRepository = $tahunPelajaranRepository;
    }

    public function getTahunPelajaransByFilters($filters){
	    return $this->tahunPelajaranRepository
      ->getTahunPelajaransByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->tahunPelajaranRepository
      ->getTahunPelajaransByFilters($filters)
      ->paginate($rowsPerPage);
    }

    public function getTahunPelajaranOptions($filters){
	    return $this->tahunPelajaranRepository->getTahunPelajaranOptions($filters)->get();
    }

    public function createTahunPelajaran($data){
      $this->tahunPelajaranRepository->insertTahunPelajaran($data);
  	}

    public function updateTahunPelajaran($data, $id){
      $this->tahunPelajaranRepository->updateTahunPelajaran($data, $id);
    }

    public function deleteTahunPelajarans($ids){
      $this->tahunPelajaranRepository->deleteTahunPelajarans($ids);          
    }
 
        
}
