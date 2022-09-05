<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHistoryOfComorbidities extends Model
{
    use HasFactory;
    protected $table = 'student_history_of_comorbidities';
    protected $fillable = [
        'history_of_comorbidities',
        'student_health_id',
        'created_at',
        'updated_at',
      ];

      public function studentcurrenthealthhistory(){
        return $this->belongsTo(StudentCurrentHealthHistory::class, 'id');
    }
}
