<?php

namespace App\Repositories;

use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class UnitRepository
{

  protected $unit;

  public function __construct(Unit $unit)
  {
    $this->unit = $unit;
  }

  public function data($request)
  {
    // return  $this->unit->with(['role:id,code,name'])->orderBy('name', 'ASC')
    //   ->when(isset($request['name']), function ($query) use ($request) {
    //     return $query->orWhere('name', $request['name']);
    //   });
  
    return  $this->unit->orderBy('name', 'ASC')
    ->when(isset($request['name']), function ($query) use ($request) {
      return $query->orWhere('name', $request['name']);
    });
  }
    
  public function getForOptions()
  {
    return $this->unit->select('id', 'name')->get();
  }

  public function getForOptionsbyIdUnit($request)
  {
    // unit_id_show, unit_type_shows
    if(isset($request['unit_id_show'])){
      // $unitidshow = json_decode($request['unit_id_show'], true);
      return $this->unit->WhereIn('id',$request['unit_id_show'])->get();
    }else{
      // $typevalueshow = json_decode($request['unit_type_show'], true);
      return $this->unit->WhereIn('unit_type_value', $request['unit_type_show'])->get();
    }
  }

  public function store($data)
  {
    return Unit::insert($data);
  }

  public function edit($id)
  {
    $result = Unit::where('id', $id)->first();
    return $result;
  }

  public function update($data)
  {
    $id = $data->id;
    $result = Unit::where('id', $id)->update([
      'name' => $data->name,
      'head_role_id' => $data->head_role_id
    ]);
    return $result;
  }

  public function destroy($data)
  {
    $id = $data->ids;
    $result = Unit::destroy($id);
    return $result;
  }
}