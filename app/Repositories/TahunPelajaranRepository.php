<?php

namespace App\Repositories;

use App\Models\TahunPelajaran;
use Carbon\Carbon;

class TahunPelajaranRepository{
  protected $tahunPelajaran;

  public function __construct(TahunPelajaran $tahunPelajaran){
    $this->tahunPelajaran = $tahunPelajaran;
  }

  public function getTahunPelajaranById($id){
    return TahunPelajaran::where('id',$id);
  }

  public function getTahunPelajaransByFilters($filters)
  {
    return $this->tahunPelajaran;
  }

  public function getTahunPelajaranOptions($filters){
    return TahunPelajaran::select('id','name')
    ->when(isset($filters['not_id']), function ($query) use ($filters) {
      return $query->where('id','<>',$filters['not_id']);
    });
  }

  public function getTahunPelajaranActive()
  {
    return TahunPelajaran::where('is_active',1);
  }

  public function insertTahunPelajaran($data){
    TahunPelajaran::insert($data);
  }

  public function insertTahunPelajaranGetId($data){
    return TahunPelajaran::insertGetId($data);
  }

  public function insertGetTahunPelajaran($data){
    return TahunPelajaran::create($data);
  }

  public function updateTahunPelajaran($data,$id){
    TahunPelajaran::where('id', $id)
            ->update($data);
  }
  
  public function deleteTahunPelajarans($ids){
    TahunPelajaran::whereIn('id', $ids)
            ->delete();
  }
}
