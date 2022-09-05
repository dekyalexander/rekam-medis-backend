<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPastMedicalHistory extends Model
{
    use HasFactory;
    protected $table = 'student_past_medical_histories';
    protected $fillable = [
        'past_medical_history',
        'student_health_id',
        'created_at',
        'updated_at',
      ];
      
       public function studentcurrenthealthhistory(){
        return $this->belongsTo(StudentCurrentHealthHistory::class, 'id');
    }
}
