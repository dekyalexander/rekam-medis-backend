<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMedicalPrescription extends Model
{
    use HasFactory;
    protected $table = 'student_medical_prescriptions';
    protected $fillable = [
        'location_id',
        'drug_id',
        'amount_medicine',
        'unit',
        'how_to_use_medicine',
        'student_treat_id',
        'created_at',
        'updated_at',
      ];

    public function studenttreatment(){
        return $this->belongsTo(StudentTreatment::class, 'id');
    }

    public function drugname(){
        return $this->hasOne(DrugName::class, 'id', 'drug_id');
    }

    public function listofukslocations(){
        return $this->hasOne(ListOfUKSLocations::class, 'id', 'location_id');
    }
}
