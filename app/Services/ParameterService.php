<?php

namespace App\Services;
use App\Repositories\ParameterRepository;

class ParameterService {

  protected $parameterRepo;

  public function __construct(ParameterRepository $parameterRepo){
    $this->parameterRepo = $parameterRepo;
  }

  public function data($request){
    $result = $this->parameterRepo->data($request);
    return $result;
  }

  public function getForOptions($group)
  {
    return $this->parameterRepo->getForOptions($group)->get();
  }

  public function store($request){
    $result = $this->parameterRepo->store($request->all());
    return $result;
  }

  public function detail($id){
    $result = $this->parameterRepo->detail($id);
    return $result;
  }

  public function update($request){
    $result = $this->parameterRepo->update($request->id, $request->all());
    return $result;
  }

  public function destroy($request){
    $result = $this->parameterRepo->destroy($request);
    return $result;
  }

}