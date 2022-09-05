<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTreatment extends Model
{
    use HasFactory;
    protected $table = 'employee_treatments';
    protected $fillable = [
        'name',
        'nik',
        'unit',
        'inspection_date',
        'anamnesa',
        'head',
        'neck',
        'eye',
        'nose',
        'tongue',
        'tonsils',
        'tooth',
        'gum',
        'throat',
        'ear',
        'lymph_nodes_and_neck',
        'heart',
        'lungs',
        'epigastrium',
        'hearts',
        'spleen',
        'intestines',
        'hand',
        'foot',
        'skin',
        'diagnosis',
        'description',
        'file',
        'created_at',
        'updated_at',
      ];

      public function generalphysicalexamination(){
        return $this->hasOne(GeneralPhysicalExamination::class, 'employee_treat_id');
    }

     public function employeevitalsigns(){
        return $this->hasOne(EmployeeVitalSigns::class, 'employee_treat_id');
    }

    public function employeemedicalprescription(){
        return $this->hasMany(EmployeeMedicalPrescription::class, 'employee_treat_id');
    }

    public function employeetreatmentgeneraldiagnosis(){
        return $this->hasMany(EmployeeTreatmentGeneralDiagnosis::class, 'employee_treat_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'id');
    }

    // public function generaldiagnosis(){
    //     return $this->hasOne(GeneralDiagnosis::class, 'id','diagnosis');
    // }

    public function employeeunit(){
        return $this->belongsTo(EmployeeUnit::class,'unit','name');
    }
}
