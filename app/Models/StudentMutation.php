<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*
id	bigint(20) UN AI PK
jenjang_id	tinyint(4)
school_id	tinyint(4)
kelas_id	tinyint(4)
parallel_id	tinyint(4)
tahun_pelajaran_id	tinyint(4)
nis	varchar(255)
niy	varchar(255)
nisn	varchar(255)
nkk	varchar(255)
photo	varchar(255)
is_active	tinyint(4)
student_status_value	tinyint(4)
tinggi	tinyint(4)
berat	tinyint(4)
created_at	timestamp
updated_at	timestamp
*/
class StudentMutation extends Model
{
    protected $table        = 'student_mutation';

    public function student(){
        return $this->belongsTo('App\Models\Student', 'niy');
    }

    public function jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'jenjang_id');
    }

    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }

    public function kelas(){
        return $this->belongsTo('App\Models\Kelas', 'kelas_id');
    }

    public function parallel(){
        return $this->belongsTo('App\Models\Parallel', 'parallel_id');
    }

    public function tahunPelajaran(){
        return $this->belongsTo('App\Models\TahunPelajaran', 'tahun_pelajaran_id');
    }

    public function student_status(){
        return $this->belongsTo('App\Models\Parameter', 'student_status_value','value')->where('group','student_status');
    }

    
}
