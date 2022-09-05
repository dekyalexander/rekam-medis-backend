<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCurrentHealthHistory extends Model
{
    use HasFactory;
    protected $table = 'student_current_health_histories';
    protected $fillable = [
        'name',
        'niy',
        'level',
        'kelas',
        'blood_group',
        'blood_group_rhesus',
        'history_of_drug_allergy',
        'covid19_illness_history',
        'covid19_sick_date',
        'covid19_vaccine_history',
        'covid19_vaccine_description',
        'created_at',
        'updated_at',
      ];

    public function studentbirthtimedata(){
        return $this->hasOne(StudentBirthTimeData::class, 'student_health_id');
    }

    public function studentcovid19vaccinehistory(){
        return $this->hasMany(StudentCovid19VaccineHistory::class, 'student_health_id');
    }

    public function studenthospitalizationhistory(){
        return $this->hasMany(StudentHospitalizationHistory::class, 'student_health_id');
    }

    public function basicimmunizationhistory(){
        return $this->hasMany(BasicImmunizationHistory::class, 'student_health_id');
    }

    public function studentfamilyhistoryofillness(){
        return $this->hasMany(StudentFamilyHistoryOfIllness::class, 'student_health_id');
    }

    public function studenthistoryofcomorbidities(){
        return $this->hasMany(StudentHistoryOfComorbidities::class, 'student_health_id');
    }

    public function studentpastmedicalhistory(){
        return $this->hasMany(StudentPastMedicalHistory::class, 'student_health_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'id');
    }

}
