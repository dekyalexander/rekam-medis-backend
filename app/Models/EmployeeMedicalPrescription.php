<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMedicalPrescription extends Model
{
    use HasFactory;
    protected $table = 'employee_medical_prescriptions';
    protected $fillable = [
        'location_id',  
        'drug_id',
        'amount_medicine',
        'unit_drug',
        'how_to_use_medicine',
        'employee_treatment_id',
        'created_at',
        'updated_at',
      ];

      public function employeetreatment(){
        return $this->belongsTo(EmployeeTreatment::class, 'id');
    }

    public function drugname(){
        return $this->hasOne(DrugName::class, 'id', 'drug_id');
    }

    public function listofukslocations(){
        return $this->hasOne(ListOfUKSLocations::class, 'id', 'location_id');
    }
}
