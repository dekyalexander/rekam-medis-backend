<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleApproval extends Model
{
    use HasFactory;

    protected $connection   = 'pusat';

    protected $table = 'role_approval';

    protected $fillable = [
        'role_id',
        'action_id',
        'level',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}