<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

/*
jenjang_id	tinyint(4)
school_id	tinyint(4)
kelas_id	tinyint(4)
jurusan_id	tinyint(4)
name	varchar(255)
code	varchar(20)
created_at	timestamp
updated_at	timestamp
 */
class Jenjang extends Model
{
  use HasFactory;

    protected $connection   = 'pusat';
    
    protected $table = 'jenjangs';

    protected $fillable = [
        'name',
        'code',
        'created_at',
        'updated_at',
    ];

    public function studentmcu(){
        return $this->hasOne(StudentMCU::class,'level', 'code');
    }

    public function studenttreatment(){
        return $this->hasOne(StudentTreatment::class, 'kelas','code');
    }

}
