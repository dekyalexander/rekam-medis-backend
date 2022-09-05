<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentVitalSigns extends Model
{
    use HasFactory;
    protected $table = 'student_vital_signs';
    protected $fillable = [
        'blood_pressure',
        'heart_rate',
        'breathing_ratio',
        'body_temperature',
        'sp02',
        'student_treatment_id',
        'created_at',
        'updated_at',
      ];

      public function studenttreatment(){
        return $this->belongsTo(StudentTreatment ::class, 'id');
    }
}
