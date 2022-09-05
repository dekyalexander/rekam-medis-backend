<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
id	bigint(20) UN AI PK
jenjang_id	tinyint(4)
school_id	tinyint(4)
name	varchar(255)
code	varchar(20)
created_at	timestamp
updated_at	timestamp
*/
class Kelas extends Model
{
    use HasFactory;
    protected $connection   = 'pusat';
    protected $table="kelases";
    
    protected $fillable = [
        'jenjang_id',
        'school_id',
        'name',
        'code',
        'created_at',
        'update_at',
      ];
  
    public function jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'jenjang_id');
    }

    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }

    public function studentmcu(){
        return $this->hasOne('App\Models\StudentMCU', 'kelas','code');
    }

    public function studenttreatment(){
        return $this->hasOne('App\Models\StudentTreatment', 'kelas','code');
    }
    
    
}
