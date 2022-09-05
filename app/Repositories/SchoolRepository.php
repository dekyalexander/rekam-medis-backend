<?php

namespace App\Repositories;

use App\Models\School;
use Carbon\Carbon;

class SchoolRepository{
  protected $school;

  public function __construct(School $school){
    $this->school = $school;
  }

  public function getSchoolById($id,$selects=['*']){
    return School::select($selects)
    ->where('id','=',$id);
  }

  public function getSchoolByJenjang($jenjang_id){
    return School::where('jenjang_id','=',$jenjang_id);
  }

  public function getSchoolsByFilters($filters)
  {
    return  School::
    with([
      'jenjang:jenjangs.id,jenjangs.name',
      'head_employee:employees.id,employees.name'
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['name']), function ($query) use ($filters) {
        return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function getSchoolOptions($filters){
    return School::select('id','name')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    })
    ->when(isset($filters['jenjang_id']), function ($query) use ($filters) {
      return $query->where('jenjang_id','=',$filters['jenjang_id']);
    });
  }

  public function insertSchool($data){
    School::insert($data);
  }

  public function insertSchoolGetId($data){
    return School::insertGetId($data);
  }

  public function insertGetSchool($data){
    return School::create($data);
  }

  public function updateSchool($data,$id){
    School::where('id', $id)
            ->update($data);
  }
  
  public function deleteSchools($ids){
    School::whereIn('id', $ids)
            ->delete();
  }
}
