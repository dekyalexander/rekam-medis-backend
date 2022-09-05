<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHistoryOfComorbidities extends Model
{
    use HasFactory;
    protected $table = 'employee_history_of_comorbidities';
    protected $fillable = [
        'history_of_comorbidities',
        'employee_health_id',
        'created_at',
        'updated_at',
      ];

      public function employeecurrenthealthhistory(){
        return $this->belongsTo(EmployeeCurrentHealthHistory::class, 'id');
    }
}
