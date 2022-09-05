<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicImmunizationHistory extends Model
{
    use HasFactory;
    protected $table = 'student_basic_immunization_histories';
    protected $fillable = [
        'type_of_immunization',
        'immunization_date',
        'value',
        'student_health_id',
        'created_at',
        'updated_at',
      ];

    public function studentcurrenthealthhistory(){
        return $this->belongsTo(StudentCurrentHealthHistory::class, 'id');
    }
}
