<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*
id	int(11) AI PK
tahun_ajaran	varchar(15)
kelas	varchar(10)
paralel	varchar(10)
jurusan	varchar(15)
*/
class KelasSMP extends Model
{
    protected $connection   = 'nilai_smp';
    protected $table        = 'ms_kelas';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
      
    
}
