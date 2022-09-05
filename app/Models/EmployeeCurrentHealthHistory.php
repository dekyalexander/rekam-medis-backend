<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCurrentHealthHistory extends Model
{
    use HasFactory;
    protected $table = 'employee_current_health_histories';
    protected $fillable = [
        'name',
        'nik',
        'unit',
        'blood_group',
        'blood_group_rhesus',
        'basic_immunization',
        'history_of_drug_allergy',
        'covid19_illness_history',
        'covid19_sick_date',
        'covid19_vaccine_history',
        'covid19_vaccine_description',
        'file',
        'created_at',
        'updated_at',
      ];

      public function employee(){
        return $this->belongsTo(Employee::class, 'id');
    }

    public function employeecovid19vaccinehistory(){
        return $this->hasMany(EmployeeCovid19VaccineHistory::class, 'employee_health_id');
    }

    public function employeehospitalizationhistory(){
        return $this->hasMany(EmployeeHospitalizationHistory::class, 'employee_health_id');
    }

    public function employeefamilyhistoryofillness(){
        return $this->hasMany(EmployeeFamilyHistoryOfIllness::class, 'employee_health_id');
    }

    public function employeehistoryofcomorbidities(){
        return $this->hasMany(EmployeeHistoryOfComorbidities::class, 'employee_health_id');
    }

    public function employeepastmedicalhistory(){
        return $this->hasMany(EmployeePastMedicalHistory::class, 'employee_health_id');
    }

    public function employeeunit(){
        return $this->belongsTo(EmployeeUnit::class,'unit','name');
    }
}
