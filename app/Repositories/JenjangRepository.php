<?php

namespace App\Repositories;

use App\Models\Jenjang;
use Carbon\Carbon;

class JenjangRepository{
  protected $jenjang;

  public function __construct(Jenjang $jenjang){
    $this->jenjang = $jenjang;
  }

  public function getJenjangById($id,$selects=['*']){
    return Jenjang::select($selects)
    ->where('id','=',$id);
  }

  public function getJenjangByCode($code)
  {
    return $this->jenjang->where('code',$code);
  }

  public function getJenjangsByFilters($filters)
  {
    return  Jenjang::
    when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['name']), function ($query) use ($filters) {
        return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function getJenjangOptions($filters){
    return Jenjang::select('id','name','code')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    })
    ->when(isset($filters['not_id']), function ($query) use ($filters) {
      return $query->where('id','<>',$filters['not_id']);
    });
  }

  public function insertJenjang($data){
    Jenjang::insert($data);
  }

  public function insertJenjangGetId($data){
    return Jenjang::insertGetId($data);
  }

  public function insertGetJenjang($data){
    return Jenjang::create($data);
  }

  public function updateJenjang($data,$id){
    Jenjang::where('id', $id)
            ->update($data);
  }
  
  public function deleteJenjangs($ids){
    Jenjang::whereIn('id', $ids)
            ->delete();
  }
}
