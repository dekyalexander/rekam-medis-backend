<?php

namespace App\Repositories;

use App\Models\Jurusan;
use App\Models\JurusanSMA;
use Carbon\Carbon;

class JurusanRepository{
  protected $jurusan;

  public function __construct(Jurusan $jurusan){
    $this->jurusan = $jurusan;
  }

  public function getAllJurusan(){
    return $this->jurusan;
  }

  public function getJurusanById($id,$selects=['*']){
    return Jurusan::select($selects)
    ->where('id','=',$id);
  }

  public function getJurusanByName($name){
    return Jurusan::where('name','=',$name);
  }

  public function getJurusansByFilters($filters)
  {
    return  Jurusan::
    with([
      'jenjang:jenjangs.id,jenjangs.name'
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['name']), function ($query) use ($filters) {
        return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function getJurusanOptions($filters){
    return Jurusan::select('id','name')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    })
    ->when(isset($filters['not_id']), function ($query) use ($filters) {
      return $query->where('id','<>',$filters['not_id']);
    });
  }

  public function getJurusanSMA(){
    return JurusanSMA::select('id','nama_jurusan');
  }

  public function insertJurusan($data){
    Jurusan::insert($data);
  }

  public function insertJurusanGetId($data){
    return Jurusan::insertGetId($data);
  }

  public function insertGetJurusan($data){
    return Jurusan::create($data);
  }

  public function updateJurusan($data,$id){
    Jurusan::where('id', $id)
            ->update($data);
  }
  
  public function deleteJurusans($ids){
    Jurusan::whereIn('id', $ids)
            ->delete();
  }
}
