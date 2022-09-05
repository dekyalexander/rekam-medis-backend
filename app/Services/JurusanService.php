<?php

namespace App\Services;
use App\Repositories\JurusanRepository;
use App\Repositories\JenjangRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class JurusanService{
    protected $jurusanRepository;
    protected $jenjangRepository;

    public function __construct(JurusanRepository $jurusanRepository, JenjangRepository $jenjangRepository){
	    $this->jurusanRepository = $jurusanRepository;
      $this->jenjangRepository = $jenjangRepository;
    }

    public function getJurusansByFilters($filters){
	    return $this->jurusanRepository
      ->getJurusansByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->jurusanRepository
      ->getJurusansByFilters($filters)
      ->paginate($rowsPerPage);
    }

    public function getJurusanOptions($filters){
	    return $this->jurusanRepository->getJurusanOptions($filters)->get();
    }

    public function syncJurusanSMA(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SMA')->first();
      $existingJurusans = $this->jurusanRepository->getAllJurusan()->pluck('name')->all();
	    $jurusans = $this->jurusanRepository->getJurusanSMA()->get();

      foreach ($jurusans as $jurusan) {
        if (!in_array($jurusan->nama_jurusan, $existingJurusans)) {
          $this->jurusanRepository->insertJurusan(
            [
              'jenjang_id' => $jenjang->id,
              'name' => $jurusan->nama_jurusan,
              'code' => null
            ]
            );
        }
      }
    }

    public function createJurusan($data){
      $this->jurusanRepository->insertJurusan($data);
  	}

    public function updateJurusan($data, $id){
      $this->jurusanRepository->updateJurusan($data, $id);
    }

    public function deleteJurusans($ids){
      $this->jurusanRepository->deleteJurusans($ids);          
    }
 
        
}
