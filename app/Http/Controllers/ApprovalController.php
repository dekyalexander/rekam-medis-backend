<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use App\Services\ApprovalService;

class ApprovalController extends Controller
{

  public $success = 200;
  public $unauth = 401;
  public $error = 500;
  public $conflict = 409;

  protected $approvalService;

  public function __construct(ApprovalService $approvalService)
  {
    $this->approvalService = $approvalService;
  }

  public function data(Request $request)
  {
    $reqParams = $request->all();

    if ($request->keyword) {
      $keys = [
        'name_action' => $request->keyword,
        'name_user' => $request->keyword,
        'name_role' => $request->keyword,
        'name_email' => $request->keyword,
      ];
      $reqParams = array_merge($reqParams, $keys);
    }

    try {
      $query = $this->approvalService->data($reqParams);

      if ($request->page) {
        $result = $query->paginate($request->rowsPerPage);
      } else {
        $result = $query->get();
      }

      return response($result);
    } catch (\Exception $e) {
      return response(['error' => $e->getMessage(), 'message' => 'failed get data']);
    }
  }


  public function store(Request $request)
  {

    $request->validate([
      'action_id' => ['required', 'numeric'],
      'creator_id' => ['required', 'numeric'],
      'approver_role_id' => ['required', 'numeric'],
      'data_id' => ['required', 'numeric'],
      'decided_id' => ['required', 'numeric'],
      'decided_at' => ['required'],
      'need_reason' => ['required', 'numeric'],
      'reason' => ['required', 'min:15'],
      'data_table_name' => ['nullable', 'min:2'],
    ]);

    $result = $this->approvalService->store($request);

    if ($result) {
      return response()->json(['message' => 'stored data'], $this->success);
    } else {
      return response()->json(['errors' => ['store' => 'stored failed']], $this->error);
    }
  }

  public function edit($id)
  {
    $result = $this->approvalService->edit($id);
    return $result;
  }

  public function update(Request $request, Approval $approval)
  {

    $request->validate([
      'id' => ['required'],
      'creator_id' => ['required', 'numeric'],
      'approver_role_id' => ['required', 'numeric'],
      'data_id' => ['required', 'numeric'],
      'decided_id' => ['required', 'numeric'],
      'decided_at' => ['required'],
      'need_reason' => ['required', 'numeric'],
      'reason' => ['required', 'min:15'],
      'data_table_name' => ['nullable', 'min:2'],
    ]);

    $result = $this->approvalService->update($request);

    if ($result) {
      return response()->json(['message' => 'changed data'], $this->success);
    } else {
      return response()->json(['errors' => ['update' => 'change failed']], $this->error);
    }
  }

  public function destroy(Request $request)
  {

    $request->validate([
      'ids' => ['required'],
    ]);

    $result = $this->approvalService->destroy($request);

    if ($result) {
      return response()->json(['message' => 'delete data'], $this->success);
    } else {
      return response()->json(['errors' => ['delete' => 'delete failed']], $this->error);
    }
  }
}
