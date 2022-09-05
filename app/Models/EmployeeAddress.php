<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    use HasFactory;
    protected $connection   = 'hris';
    protected $table        = 'employee_addresses';

    protected $fillable = [
        'employee_id',
        'address',
        'created_at',
        'update_at',
      ];

     public function employeehris(){
        return $this->belongsTo(EmployeeHRIS::class,'employee_id','id');
    }
}
