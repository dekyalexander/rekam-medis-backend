<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCovid19VaccineHistory extends Model
{
   use HasFactory;
    protected $table = 'student_covid19_vaccine_histories';
    protected $fillable = [
        // 'vaccine_history',
        // 'description',
        'vaccine_to',
        'vaccine_date',
        'student_health_id',
        'created_at',
        'updated_at',
      ];

    public function studentcurrenthealthhistory(){
        return $this->belongsTo(StudentCurrentHealthHistory::class, 'id');
    }
}
