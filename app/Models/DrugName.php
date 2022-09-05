<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugName extends Model
{
    use HasFactory;
    protected $table = 'drug_names';
    protected $fillable = [
        'drug_kode',
        'drug_name',
        'created_at',
        'updated_at',
      ];

    public function drug(){
        return $this->belongsTo(Drug::class,'id', 'drug_name_id');
    }

    // public function drugdistribution(){
    //     return $this->belongsTo(DrugDistribution::class,'id', 'drug_name_id','location_id');
    // }

    public function drugdistribution(){
        return $this->hasMany(DrugDistribution::class,'drug_name_id', 'id');
    }


    public function listofukslocations(){
        return $this->belongsTo(ListofUKSLocations::class,'id', 'drug_name_id','location_id');
    }

    public function drugexpired(){
        return $this->belongsTo(DrugExpired::class,'id', 'drug_id');
    }

    public function stocks(){
        return $this->belongsTo(Stocks::class,'id', 'drug_id');
    }

    public function transactions(){
        return $this->belongsTo(Transactions::class,'id','drug_id');
    }

    public function studentmedicalprescription(){
        return $this->belongsTo(StudentMedicalPrescription::class,'id', 'student_treat_id','drug_id');
    }

    public function employeemedicalprescription(){
        return $this->belongsTo(EmployeeMedicalPrescription::class,'id', 'employee_treat_id','drug_id');
    }
}
