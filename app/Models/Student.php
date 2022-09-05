<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*
id	bigint(20) UN AI PK
user_id	bigint(20)
father_parent_id	bigint(20)
mother_parent_id	bigint(20)
father_employee_id	bigint(20)
mother_employee_id	bigint(20)
wali_parent_id	bigint(20)
wali_employee_id	bigint(20)
jenjang_id	tinyint(4)
school_id	tinyint(4)
kelas_id	tinyint(4)
parallel_id	tinyint(4)
masuk_tahun_id	tinyint(4)
masuk_jenjang_id	tinyint(4)
masuk_kelas_id	tinyint(4)
is_father_alive	tinyint(4)
is_mother_alive	tinyint(4)
is_poor	tinyint(4)
nis	varchar(255)
niy	varchar(255)
nisn	varchar(255)
nkk	varchar(255)
father_ktp	varchar(255)
mother_ktp	varchar(255)
name	varchar(255)
email	varchar(255)
sex_type_value	tinyint(4)
address	text
kota	varchar(255)
kecamatan	varchar(255)
kelurahan	varchar(255)
kodepos	varchar(255)
photo	varchar(255)
handphone	varchar(255)
birth_place	varchar(255)
birth_date	date
birth_order	tinyint(4)
religion_value	tinyint(4)
nationality	varchar(255)
language	varchar(255)
is_adopted	tinyint(4)
stay_with_value	tinyint(4)
siblings	tinyint(4)
is_sibling_student	tinyint(4)
foster	tinyint(4)
step_siblings	tinyint(4)
medical_history	varchar(255)
is_active	tinyint(4)
student_status_value	tinyint(4)
lulus_tahun_id	tinyint(4)
tahun_lulus	year(4)
gol_darah	char(3)
is_cacat	tinyint(4)
tinggi	tinyint(4)
berat	tinyint(4)
sekolah_asal	varchar(255)
created_at	timestamp
updated_at	timestamp
*/
class Student extends Model
{

    protected $connection   = 'pusat';
    
    protected $table = 'students';

    protected $fillable = [
        'name',
        'niy',
        'jenjang_id',
        'kelas_id',
        'school_id',
        'birth_date',
        'sex_type_value',
        'handphone',
        'address',
        'kodepos',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function sex_type(){
        return $this->belongsTo('App\Models\Parameter', 'sex_type_value','value')->where('group','sex_type');
    }

    public function religion(){
        return $this->belongsTo('App\Models\Parameter', 'religion_value','value')->where('group','religion');
    }

    
    public function stay_with(){
        return $this->belongsTo('App\Models\Parameter', 'stay_with_value','value')->where('group','stay_with');
    }

    public function jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'jenjang_id');
    }

    public function masuk_jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'masuk_jenjang_id');
    }

    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }

    public function parent_mother(){
        return $this->belongsTo('App\Models\Parents', 'mother_parent_id');
    }

    public function parent_father(){
        return $this->belongsTo('App\Models\Parents', 'father_parent_id');
    }

    public function employee_mother(){
        return $this->belongsTo('App\Models\Employee', 'mother_employee_id');
    }

    public function employee_father(){
        return $this->belongsTo('App\Models\Employee', 'father_employee_id');
    }    

    public function kelas(){
        return $this->belongsTo('App\Models\Kelas', 'kelas_id');
    }

    public function masuk_kelas(){
        return $this->belongsTo('App\Models\Kelas', 'masuk_kelas_id');
    }

    public function parallel(){
        return $this->belongsTo('App\Models\Parallel', 'parallel_id');
    }

    public function masuk_tahun(){
        return $this->belongsTo('App\Models\TahunPelajaran', 'masuk_tahun_id');
    }

    public function lulus_tahun(){
        return $this->belongsTo('App\Models\TahunPelajaran', 'lulus_tahun_id');
    }

    public function student_status(){
        return $this->belongsTo('App\Models\Parameter', 'student_status_value','value')->where('group','student_status');
    }

    public function siblings_from_father(){
        return $this->hasMany(Student::class, 'father_parent_id', 'father_parent_id');
    }

    public function siblings_from_mother(){
        return $this->hasMany(Student::class, 'mother_parent_id', 'mother_parent_id');
    }

    public function siblings_from_kk(){
        return $this->hasMany(Student::class, 'nkk', 'nkk')->where('nkk','<>','');
    }

    public function studentmutation(){
        return $this->hasMany(StudentMutation::class, 'niy', 'niy');
    }

    public function studentcurrenthealthhistory(){
        return $this->hasOne(StudentCurrentHealthHistory::class, 'student_id');
    }

    public function studentmcu(){
        return $this->hasOne(StudentMCU::class, 'student_id','name');
    }

    public function parents(){
        return $this->hasOne(Parents::class, 'id');
    }

    public function tahunpelajaran(){
        return $this->belongsTo(TahunPelajaran::class, 'id');
    }

    public function parameter(){
        return $this->belongsTo(Parameter::class, 'id');
    }

    
}
