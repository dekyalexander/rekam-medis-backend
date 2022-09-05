<?php

namespace App\Repositories;

use App\Models\Kelas;
use App\Models\KelasTK;
use App\Models\KelasSD;
use App\Models\KelasSMP;
use App\Models\KelasSMA;
use App\Models\StudentTK;
use Carbon\Carbon;

class KelasRepository{
  protected $kelas;

  public function __construct(Kelas $kelas){
    $this->kelas = $kelas;
  }

  public function getAllKelas(){
    return $this->kelas;
  }

  public function getKelasById($id,$selects=['*']){
    return Kelas::select($selects)
    ->where('id','=',$id);
  }

  public function getKelasByNameAndJenjangId($name, $jenjang_id){
    return Kelas::where('name','=',$name)
    ->where('jenjang_id','=',$jenjang_id);
  }

  public function getKelassByFilters($filters)
  {
    return  Kelas::
    with([
      'jenjang:jenjangs.id,jenjangs.name',
      'school:schools.id,schools.name'
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['name']), function ($query) use ($filters) {
        return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function getKelasOptions($filters){
    return Kelas::select('id','name','code')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    })
    ->when(isset($filters['school_id']), function ($query) use ($filters) {
      return $query->where('school_id','=',$filters['school_id']);
    })
    ->when(isset($filters['jenjang_id']), function ($query) use ($filters) {
      return $query->where('jenjang_id','=',$filters['jenjang_id']);
    });
  }

  public function getKelasTK(){
    return StudentTK::whereNotNull('level')
    ->where('level','<>','')
    ->groupBy('level');
  }

  public function getKelasSD($tahun){
    return KelasSD::select('id','kelas','paralel','jurusan')
    ->groupBy('kelas');
  }

  public function getKelasSMP($tahun){
    return KelasSMP::select('id','kelas','tahun_ajaran')
    ->where('tahun_ajaran',$tahun)
    ->groupBy('kelas');
  }

  public function getKelasSMA($tahun){
    return KelasSMA::select('id','kelas')
    ->groupBy('kelas');
  }

  public function insertKelas($data){
    Kelas::insert($data);
  }

  public function insertKelasGetId($data){
    return Kelas::insertGetId($data);
  }

  public function insertGetKelas($data){
    return Kelas::create($data);
  }

  public function updateKelas($data,$id){
    Kelas::where('id', $id)
            ->update($data);
  }
  
  public function deleteKelass($ids){
    Kelas::whereIn('id', $ids)
            ->delete();
  }
}
