<?php

namespace App\Services;
use App\Repositories\KelasRepository;
use App\Repositories\TahunPelajaranRepository;
use App\Repositories\JenjangRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class KelasService{
    protected $kelasRepository;
    protected $tahunPelajaranRepository;
    protected $jenjangRepository;
    protected $schoolRepository;

    public function __construct(SchoolRepository $schoolRepository, JenjangRepository $jenjangRepository, KelasRepository $kelasRepository, TahunPelajaranRepository $tahunPelajaranRepository){
	    $this->kelasRepository = $kelasRepository;
      $this->tahunPelajaranRepository = $tahunPelajaranRepository;
      $this->jenjangRepository = $jenjangRepository;
      $this->schoolRepository = $schoolRepository;
    }

    public function getKelassByFilters($filters){
	    return $this->kelasRepository
      ->getKelassByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->kelasRepository
      ->getKelassByFilters($filters)
      ->paginate($rowsPerPage);
    }

    public function getKelasOptions($filters){
	    return $this->kelasRepository->getKelasOptions($filters)->get();
    }

    public function createKelas($data){
      $this->kelasRepository->insertKelas($data);
  	}

    public function updateKelas($data, $id){
      $this->kelasRepository->updateKelas($data, $id);
    }

    public function syncKelasTK(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('TK')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $existingKelases = $this->kelasRepository->getAllKelas()->pluck('name')->all();
	    $kelases = $this->kelasRepository->getKelasTK()->pluck('level');
      
      foreach ($kelases as $kelas) {
        if (!in_array(trim($kelas), $existingKelases)) {
          $this->kelasRepository->insertKelas(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'name' => trim($kelas),
              'code' => trim($kelas)
            ]
            );
        }
      }
    }

    public function syncKelasSD(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SD')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingKelases = $this->kelasRepository->getAllKelas()->pluck('name')->all();
	    $kelases = $this->kelasRepository->getKelasSD($tahunActive->name)->get();

      foreach ($kelases as $kelas) {
        if (!in_array($kelas->kelas, $existingKelases) && !in_array($this->getKelasName($kelas->kelas), $existingKelases)) {
          $this->kelasRepository->insertKelas(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'name' => $kelas->kelas,
              'code' => $kelas->kelas
            ]
            );
        }
      }
    }

    public function syncKelasSMP(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SMP')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingKelases = $this->kelasRepository->getAllKelas()->pluck('name')->all();
	    $kelases = $this->kelasRepository->getKelasSMP($tahunActive->name)->get();
//return $kelases;
      foreach ($kelases as $kelas) {
        if (!in_array($kelas->kelas, $existingKelases) && !in_array($this->getKelasName($kelas->kelas), $existingKelases)) {
          $this->kelasRepository->insertKelas(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'name' => $kelas->kelas,
              'code' => $kelas->kelas
            ]
            );
        }
      }
    }

    

    public function syncKelasSMA(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('SMA')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingKelases = $this->kelasRepository->getAllKelas()->pluck('name')->all();
	    $kelases = $this->kelasRepository->getKelasSMA($tahunActive->name)->get();

      foreach ($kelases as $kelas) {
        if (!in_array($kelas->kelas, $existingKelases)) {
          $this->kelasRepository->insertKelas(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'name' => $kelas->kelas,
              'code' => $kelas->kelas
            ]
            );
        }
      }
    }

    public function syncKelasPCI(){
      $jenjang = $this->jenjangRepository->getJenjangByCode('PCI')->first();
      $school = $this->schoolRepository->getSchoolByJenjang($jenjang->id)->first();
      $tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      $existingKelases = $this->kelasRepository->getAllKelas()->pluck('name')->all();
	    $kelases = $this->kelasRepository->getKelasTK($tahunActive->name)->get();

      foreach ($kelases as $kelas) {
        if (!in_array($kelas->nama, $existingKelases)) {
          $this->kelasRepository->insertKelas(
            [
              'jenjang_id' => $jenjang->id,
              'school_id' => $school->id,
              'name' => $kelas->nama,
              'code' => $kelas->nama
            ]
            );
        }
      }
    }

    public function deleteKelass($ids){
      $this->kelasRepository->deleteKelass($ids);          
    }

    function getKelasName($kelasName){
      if($kelasName==='I'){
        return '1';
      }
      elseif($kelasName==='II'){
        return '2';
      }
      elseif($kelasName==='III'){
        return '3';
      }
      elseif($kelasName==='IV'){
        return '4';
      }
      elseif($kelasName==='V'){
        return '5';
      }
      elseif($kelasName==='VI'){
        return '6';
      }
      elseif($kelasName==='VII'){
        return '7';
      }
      elseif($kelasName==='VIII'){
        return '8';
      }
      elseif($kelasName==='IX'){
        return '9';
      }
      elseif($kelasName==='X'){
        return '10';
      }
      elseif($kelasName==='XI'){
        return '11';
      }
      elseif($kelasName==='XII'){
        return '12';
      }
    }
 
        
}
