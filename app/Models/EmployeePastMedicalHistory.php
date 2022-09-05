<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePastMedicalHistory extends Model
{
    use HasFactory;
    protected $table = 'employee_past_medical_histories';
    protected $fillable = [
        'past_medical_history',
        'employee_health_id',
        'created_at',
        'updated_at',
      ];
      
       public function employeecurrenthealthhistory(){
        return $this->belongsTo(EmployeeCurrentHealthHistory::class, 'id');
    }
}
