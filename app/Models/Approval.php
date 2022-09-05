<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
  use HasFactory;

  protected $connection   = 'pusat';

  protected $fillable = [
    'action_id',
    'creator_id',
    'approver_role_id',
    'data_id',
    'decided_id',
    'decided_at',
    'need_reason',
    'reason',
    'data_table_name',
    'next',
    'prev',
    'status',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  public function action()
  {
    return $this->hasOne(Action::class, 'id', 'action_id');
  }

  public function role()
  {
    return $this->hasOne(Role::class, 'id', 'approver_role_id');
  }

  public function users_creator()
  {
    return $this->hasOne(User::class, 'id', 'creator_id');
  }

  public function users_decided()
  {
    return $this->hasOne(User::class, 'id', 'decided_id');
  }
}
