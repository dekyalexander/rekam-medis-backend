<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCovid19VaccineHistory extends Model
{
    use HasFactory;
    protected $table = 'employee_covid19_vaccine_histories';
    protected $fillable = [
        // 'vaccine_history',
        // 'description',
        'vaccine_to',
        'vaccine_date',
        'employee_health_id',
        'created_at',
        'updated_at',
      ];

      public function employeecurrenthealthhistory(){
        return $this->belongsTo(EmployeeCurrentHealthHistory::class, 'id');
    }
}
