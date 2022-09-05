<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCUDiagnosis extends Model
{
    use HasFactory;
    protected $table = 'mcu_diagnosis';
    protected $fillable = [
        'kode_diagnosis',
        'diagnosis_name',
        'created_at',
        'updated_at',
      ];

    // public function studentmcu(){
    //     return $this->belongsTo(StudentMCU::class, 'id', 'dental_diagnosis');
    // }

    public function studentmcudentalandoraldiagnosis(){
        return $this->belongsTo(StudentMCUDentalAndOralDiagnosis::class, 'id','diagnosis_dental_id');
    }
}
