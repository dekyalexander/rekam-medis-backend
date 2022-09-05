<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOfUKSLocations extends Model
{
    use HasFactory;
    protected $table = 'list_of_uks_locations';
    protected $fillable = [
        'uks_name',
        'created_at',
        'updated_at',
      ];

    public function drug(){
        return $this->belongsTo(Drug::class,'id', 'drug_name_id', 'drug_unit_id');
    }

    public function drugdistribution(){
        return $this->hasMany(DrugDistribution::class,'location_id','id');
    }

    public function drugexpired(){
        return $this->belongsTo(DrugExpired::class,'id', 'drug_id');
    }

    public function stocks(){
        return $this->belongsTo(Stocks::class,'id', 'drug_id');
    }

    public function locationdrug(){
        return $this->belongsTo(LocationDrug::class, 'id','location_id');
    }
    public function uksofficerregistrations(){
        return $this->belongsTo(UKSOfficerRegistration::class, 'id','job_location_id');
    }

     public function transactions(){
        return $this->belongsTo(Transactions::class,'id','location_id');
    }

    public function studentmedicalprescription(){
        return $this->belongsTo(StudentMedicalPrescription::class, 'id','student_treat_id','location_id');
    }

    public function employeemedicalprescription(){
        return $this->belongsTo(EmployeeMedicalPrescription::class, 'id','employee_treat_id','location_id');
    }
}
