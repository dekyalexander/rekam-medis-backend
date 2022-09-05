<?php

namespace App\Services;
use App\Repositories\ParallelRepository;
use App\Repositories\TahunPelajaranRepository;
use App\Repositories\JenjangRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\KelasRepository;
use App\Repositories\JurusanRepository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class ParallelService{
    protected $parallelRepository;
    protected $tahunPelajaranRepository;
    protected $jenjangRepository;
    protected $schoolRepository;
    protected $kelasRepository;
    protected $jurusanRepository;

    public function __construct(JurusanRepository $jurusanRepository, SchoolRepository $schoolRepository, JenjangRepository $jenjangRepository, KelasRepository $kelasRepository, TahunPelajaranRepository $tahunPelajaranRepository, ParallelRepository $parallelRepository){
	    $this->parallelRepository = $parallelRepository;
      $this->kelasRepository = $kelasRepository;
      $this->tahunPelajaranRepository = $tahunPelajaranRepository;
      $this->jenjangRepository = $jenjangRepository;
      $this->schoolRepository = $schoolRepository;
      $this->jurusanRepository = $jurusanRepository;
    }

    public function getParallelsByFilters($filters){
	    return $this->parallelRepository
      ->getParallelsByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->parallelRepository
      ->getParallelsByFilters($filters)
      ->paginate($rowsPerPage);
    }

    public function getParallelOptions($filters){
	    return $this->parallelRepository->getParallelOptions($filters)->get();
    }

    public function syncParallelTK(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('TK')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingParallels = $this->parallelRepository->getAllParallel()->pluck('name')->all();
	    $parallels = $this->parallelRepository->getParallelTK()->get();
            
      foreach ($parallels as $parallel) {
        if (!in_array(trim($parallel->kelas), $existingParallels)) {
          $kelasId = $this->kelasRepository->getKelasByNameAndJenjangId(trim($parallel->level), $jenjang->id)->value('id');
          $this->parallelRepository->insertParallel(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'kelas_id' => $kelasId,
              'jurusan_id'=> null,
              'name' => trim($parallel->kelas),
              'code' => trim($parallel->kelas)
            ]
            );
        }
      }
    }

    public function syncParallelSD(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SD')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingParallels = $this->parallelRepository->getAllParallel()->pluck('name')->all();
	    $parallels = $this->parallelRepository->getParallelSD($tahunActive->name)->get();
          
      foreach ($parallels as $parallel) {
        if (!in_array($parallel->paralel, $existingParallels)) {
          $kelasId = $this->kelasRepository->getKelasByNameAndJenjangId($parallel->kelas, $jenjang->id)->select('id','name')->value('id');
          $this->parallelRepository->insertParallel(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'kelas_id' => $kelasId,
              'jurusan_id'=> null,
              'name' => $parallel->paralel,
              'code' => $parallel->paralel
            ]
            );
        }
      }
    }

    public function syncParallelSMP(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SMP')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingParallels = $this->parallelRepository->getAllParallel()->pluck('name')->all();
	    $parallels = $this->parallelRepository->getParallelSMP($tahunActive->name)->get();
          
      foreach ($parallels as $parallel) {
        if (!in_array($parallel->paralel, $existingParallels)) {
          $kelasId = $this->kelasRepository->getKelasByNameAndJenjangId($parallel->kelas, $jenjang->id)->select('id','name')->value('id');
          $this->parallelRepository->insertParallel(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'kelas_id' => $kelasId,
              'jurusan_id'=> null,
              'name' => $parallel->paralel,
              'code' => $parallel->paralel
            ]
            );
        }
      }
    }

    public function syncParallelSMA(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SMA')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingParallels = $this->parallelRepository->getParallelWithKelas()->get();
	    $parallels = $this->parallelRepository->getParallelSMA($tahunActive->name)->get();
      
      foreach ($parallels as $parallel) {
        $exist = false;
        foreach ($existingParallels as $existing) {          
          if($parallel->kelas==$existing->kelas->name && $parallel->pararel==$existing->name){
            $exist=true;
          }
        }
        if(!$exist){
          $kelasId = $this->kelasRepository->getKelasByNameAndJenjangId($parallel->kelas, $jenjang->id)->select('id','name')->value('id');
          
          $jurusanId = null;
          if($parallel->jurusanSMA!==null){
            $jurusanId = $this->jurusanRepository
            ->getJurusanByName($parallel->jurusanSMA->nama_jurusan)
            ->value('id');
          }
          
          
          
          $this->parallelRepository->insertParallel(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'kelas_id' => $kelasId,
              'jurusan_id'=> $jurusanId,
              'name' => $parallel->pararel,
              'code' => $parallel->pararel
            ]
            );
        }
         
      }
    }

    public function syncParallelPCI(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('PCI')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingParallels = $this->parallelRepository->getAllParallel()->pluck('name')->all();
	    $parallels = $this->parallelRepository->getParallelPCI($tahunActive->name)->get();
          
      foreach ($parallels as $parallel) {
        if (!in_array($parallel->paralel, $existingParallels)) {
          $kelasId = $this->kelasRepository->getKelasByNameAndJenjangId($parallel->kelas, $jenjang->id)->select('id','name')->value('id');
          $this->parallelRepository->insertParallel(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'kelas_id' => $kelasId,
              'jurusan_id'=> null,
              'name' => $parallel->paralel,
              'code' => $parallel->paralel
            ]
            );
        }
      }
    }

    public function createParallel($data){
      $this->parallelRepository->insertParallel($data);
  	}

    public function updateParallel($data, $id){
      $this->parallelRepository->updateParallel($data, $id);
    }

    public function deleteParallels($ids){
      $this->parallelRepository->deleteParallels($ids);          
    }
 
        
}
