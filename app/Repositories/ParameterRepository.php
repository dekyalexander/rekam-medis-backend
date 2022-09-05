<?php

namespace App\Repositories;

use App\Models\Parameter;
use Illuminate\Support\Facades\DB;

class ParameterRepository
{
  protected $parameter;

  public function __construct(Parameter $parameter)
  {
    $this->parameter = $parameter;
  }

  public function data($request)
  {
    return  $this->parameter->orderBy('name', 'ASC');
  }

  public function getReligionParameters($religionName)
  {
    return  $this->parameter
        ->where('group','=','religion')
        ->where('name','like','%'.$religionName.'%');
  }



  public function getForOptions($group)
  {
    return Parameter::select('value','code','name')
    ->where('group','=',$group);
  }

  public function store($data)
  {
    $result = Parameter::create($data);
    return $result;
  }

  public function detail($id)
  {
    $result = Parameter::where('id', $id)->first();
    return $result;
  }

  public function update($id, $data)
  {
    $result = Parameter::where('id', $id)->update($data);

    return $result;
  }

  public function destroy($data)
  {

    $id = $data->ids;

    $result = Parameter::destroy($id);

    return $result;
  }
}
