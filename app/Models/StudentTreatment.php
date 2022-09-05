<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTreatment extends Model
{
    use HasFactory;
    protected $table = 'student_treatments';
    protected $fillable = [
        'name',
        'niy',
        'level',
        'kelas',
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
        'created_at',
        'updated_at',
      ];

      public function studentgeneralphysicalexamination(){
        return $this->hasOne(StudentGeneralPhysicalExamination::class, 'student_treat_id');
    }

     public function studentvitalsigns(){
        return $this->hasOne(StudentVitalSigns::class, 'student_treat_id');
    }

    public function studentmedicalprescription(){
        return $this->hasMany(StudentMedicalPrescription::class, 'student_treat_id');
    }

    public function studenttreatmentgeneraldiagnosis(){
        return $this->hasMany(StudentTreatmentGeneralDiagnosis::class, 'student_treat_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'id');
    }

    public function jenjang(){
        return $this->belongsTo(Jenjang::class, 'level', 'code');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas', 'code');
    }

    public function generaldiagnosis(){
        return $this->hasOne(GeneralDiagnosis::class, 'id','diagnosis');
    }
}
