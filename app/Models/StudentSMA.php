<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
id	int(9) AI PK
tahunajaran	varchar(9)
nis	varchar(8)
niy	varchar(15)
nin	varchar(25)
nama	varchar(50)
jenjang	varchar(5)
kelas	int(11)
status	tinyint(1)
tanggal_diterima	varchar(50)
dibuat_oleh	int(11)
tanggal_buat	datetime
*/
class StudentSMA extends Model
{
    protected $connection   = 'nilai_sma_2017';
    protected $table        = 'mst_sma_siswa';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;

    public function bukuInduk(){
        return $this->hasOne('App\Models\BukuIndukSMA', 'noinduksiswa','niy');
    }

    public function kelasSMA(){
        return $this->belongsTo('App\Models\KelasSMA', 'kelas');
    }
}
