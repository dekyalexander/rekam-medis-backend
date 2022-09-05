<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class EmployeeCareerTransitionType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
    						'parent',
							'name',
							'status',
          				];

	protected $table = 'employee_career_transition_types';          				

}