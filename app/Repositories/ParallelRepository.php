<?php

namespace App\Repositories;

use App\Models\Parallel;
use App\Models\KelasTK;
use App\Models\KelasSD;
use App\Models\KelasSMP;
use App\Models\KelasSMA;
use App\Models\StudentTK;
use Carbon\Carbon;

class ParallelRepository{
  protected $parallel;

  public function __construct(Parallel $parallel){
    $this->parallel = $parallel;
  }

  public function getAllParallel(){
    return $this->parallel;
  }

  public function getParallelWithKelas(){
    return  Parallel::
    with([
      'kelas:kelases.id,kelases.name'
    ]);
  }

  public function getParallelById($id,$selects=['*']){
    return Parallel::select($selects)
    ->where('id','=',$id);
  }

  public function getParallelByNameAndKelasId($name, $kelas_id){
    return Parallel::where('name','=',$name)
            ->where('kelas_id','=',$kelas_id);
  }

  public function getParallelByNameAndJenjangId($name, $jenjang_id){
    return Parallel::where('name','=',$name)
            ->where('jenjang_id','=',$jenjang_id);
  }

  public function getParallelsByFilters($filters)
  {
    return  Parallel::
    with([
      'jenjang:jenjangs.id,jenjangs.name',
      'school:schools.id,schools.name',
      'kelas:kelases.id,kelases.name',
      'jurusan:jurusans.id,jurusans.code,jurusans.name',
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['name']), function ($query) use ($filters) {
        return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function getParallelOptions($filters){
    return Parallel::select('id','name')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    })
    ->when(isset($filters['kelas_id']), function ($query) use ($filters) {
      return $query->where('kelas_id','=',$filters['kelas_id']);
    });
  }

  public function getParallelTK(){
    return StudentTK::select('level','kelas')
    ->whereNotNull('level')
    ->where('level','<>','')
    ->whereNotNull('kelas')
    ->where('kelas','<>','')
    ->groupBy('kelas');
  }

  public function getParallelSD($tahun){
    return KelasSD::select('id','kelas','paralel','jurusan')
    ->groupBy('paralel');
  }

  public function getParallelSMP($tahun){
    return KelasSMP::select('id','kelas','paralel','tahun_ajaran')
    ->where('tahun_ajaran',$tahun)
    ->groupBy('paralel');
  }

  public function getParallelSMA($tahun){
    return KelasSMA::with(['jurusanSMA']);
  }

  public function insertParallel($data){
    Parallel::insert($data);
  }

  public function insertParallelGetId($data){
    return Parallel::insertGetId($data);
  }

  public function insertGetParallel($data){
    return Parallel::create($data);
  }

  public function updateParallel($data,$id){
    Parallel::where('id', $id)
            ->update($data);
  }
  
  public function deleteParallels($ids){
    Parallel::whereIn('id', $ids)
            ->delete();
  }
}
