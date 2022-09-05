<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyHistoryOfIllness extends Model
{
     use HasFactory;
    protected $table = 'employee_family_history_of_illnesses';
    protected $fillable = [
        'family_history_of_illness',
        'employee_health_id',
        'created_at',
        'updated_at',
      ];

      public function employeecurrenthealthhistory(){
        return $this->belongsTo(EmployeeCurrentHealthHistory::class, 'id');
    }
}
