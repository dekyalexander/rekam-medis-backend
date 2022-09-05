<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFamilyHistoryOfIllness extends Model
{
     use HasFactory;
    protected $table = 'student_family_history_of_illnesses';
    protected $fillable = [
        'family_history_of_illness',
        'student_health_id',
        'created_at',
        'updated_at',
      ];

      public function studentcurrenthealthhistory(){
        return $this->belongsTo(StudentCurrentHealthHistory::class, 'id');
    }
}
