<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHospitalizationHistory extends Model
{
    use HasFactory;
    protected $table = 'employee_hospitalization_histories';
    protected $fillable = [
        'hospital_name',
        'date_treated',
        'diagnosis',
        'other_diagnosis',
        'employee_health_id',
        'created_at',
        'updated_at',
      ];

      public function employeecurrenthealthhistory(){
        return $this->belongsTo(EmployeeCurrentHealthHistory::class, 'id');
    }
}
