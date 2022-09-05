<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHospitalizationHistory extends Model
{
    use HasFactory;
    protected $table = 'student_hospitalization_histories';
    protected $fillable = [
        'hospital_name',
        'date_treated',
        'diagnosis',
        'other_diagnosis',
        'student_health_id',
        'created_at',
        'updated_at',
      ];

    public function studentcurrenthealthhistory(){
        return $this->belongsTo(StudentCurrentHealthHistory::class, 'id');
    }
}
