<?php

namespace App\Services;

use App\Repositories\ApprovalRepository;

class ApprovalService
{
  protected $approvalRepo;

  public function __construct(ApprovalRepository $approvalRepo)
  {
    $this->approvalRepo = $approvalRepo;
  }

  public function data($request)
  {
    $result = $this->approvalRepo->data($request);
    return $result;
  }

  public function store($request)
  {
    $result = $this->approvalRepo->store($request);
    return $result;
  }

  public function edit($id)
  {
    $result = $this->approvalRepo->edit($id);
    return $result;
  }

  public function update($request)
  {
    $result = $this->approvalRepo->update($request);
    return $result;
  }

  public function destroy($request)
  {
    $result = $this->approvalRepo->destroy($request);
    return $result;
  }
}
