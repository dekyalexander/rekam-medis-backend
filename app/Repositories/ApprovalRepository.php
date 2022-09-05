<?php

namespace App\Repositories;

use App\Models\Approval;
use Illuminate\Support\Facades\DB;


class ApprovalRepository
{
  protected $approval;

  public function __construct(Approval $approval)
  {
    $this->approval = $approval;
  }

  public function data($request)
  {
    return  $this->approval::with(['action', 'role', 'users_creator', 'users_decided'])->orderBy('id', 'ASC')
      ->when(isset($request['name_action']), function ($query)  use ($request) {
        $query->WhereHas('action', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_action'] . '%');
        });
      })
      ->when(isset($request['name_user']), function ($query)  use ($request) {
        $query->OrWhereHas('users_creator', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_user'] . '%');
        });
      })
      ->when(isset($request['name_email']), function ($query)  use ($request) {
        $query->OrWhereHas('users_creator', function ($q) use ($request) {
          return $q->where('email', 'LIKE', '%' . $request['name_email'] . '%');
        });
      })
      ->when(isset($request['name_role']), function ($query)  use ($request) {
        $query->OrWhereHas('role', function ($q) use ($request) {
          return $q->where('name', 'LIKE', '%' . $request['name_role'] . '%');
        });
      });
  }

  public function store($data)
  {
    $result = Approval::create([
      'action_id' => $data->action_id,
      'creator_id' => $data->creator_id,
      'approver_role_id' => $data->approver_role_id,
      'data_id' => $data->data_id,
      'decided_id' => $data->decided_id,
      'decided_at' => $data->decided_at,
      'need_reason' => $data->need_reason,
      'reason' => $data->reason,
      'data_table_name' => $data->data_table_name,
      'next' => $data->next,
      'prev' => $data->prev,
      'status' => $data->status,
    ]);
    return $result;
  }

  public function edit($id)
  {
    $result = Approval::WHERE('id', $id)->get();
    return $result;
  }

  public function update($data)
  {
    $id = $data->id;
    $result = Approval::WHERE('id', $id)->update([
      'action_id' => $data->action_id,
      'creator_id' => $data->creator_id,
      'approver_role_id' => $data->approver_role_id,
      'data_id' => $data->data_id,
      'decided_id' => $data->decided_id,
      'decided_at' => $data->decided_at,
      'need_reason' => $data->need_reason,
      'reason' => $data->reason,
      'data_table_name' => $data->data_table_name,
      'next' => $data->next,
      'prev' => $data->prev,
      'status' => $data->status,
    ]);

    return $result;
  }

  public function destroy($data)
  {
    $id = $data->id;
    $result =  Approval::destroy($id);
    return $result;
  }

  public function deleteApprovalByActionIds($action_ids)
  {
    return Approval::whereIn('action_id', $action_ids)->delete();    
  }
}
