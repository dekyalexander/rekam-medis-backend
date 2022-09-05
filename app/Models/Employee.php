<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $connection   = 'pusat';
    protected $table = 'employees';
    protected $fillable = [
        'user_id',
        'name',
        'created_at',
        'update_at',
      ];
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function employeecurrenthealthhistory(){
        return $this->hasOne(EmployeeCurrentHealthHistory::class, 'id');
    }

    public function employeetreatment(){
        return $this->hasOne(EmployeeTreatment::class, 'id');
    }
}
