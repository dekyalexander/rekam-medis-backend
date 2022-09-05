<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisusDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'visus_diagnosis';
    protected $fillable = [
      'diagnosis_kode',  
      'diagnosis_name',
        'created_at',
        'updated_at',
      ];

    //   public function studentmcu(){
    //     return $this->belongsTo(StudentMCU::class, 'id','eye_diagnosis');
    // }

     public function studentmcueyediagnosis(){
        return $this->belongsTo(StudentMCUEyeDiagnosis::class, 'id','diagnosis_eye_id');
    }
}
