<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
id	bigint(20) UN AI PK
jenjang_id	tinyint(4)
school_id	tinyint(4)
kelas_id	tinyint(4)
jurusan_id	tinyint(4)
name	varchar(255)
code	varchar(20)
created_at	timestamp
updated_at	timestamp
*/
class Parallel extends Model
{
  
    public function jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'jenjang_id');
    }

    public function kelas(){
        return $this->belongsTo('App\Models\Kelas', 'kelas_id');
    }

    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }

    public function jurusan(){
        return $this->belongsTo('App\Models\Jurusan', 'jurusan_id');
    }
}
