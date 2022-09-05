<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
id	int(11) AI PK
nis	varchar(30)
nama	varchar(80)
level	varchar(30)
kelas	varchar(70)
tahun_ajaran	varchar(20)
jenjang	varchar(10)
tmp_lahir	varchar(50)
tgl_lahir	date
password	varchar(80)
active	tinyint(4)
user_input	varchar(40)
date	datetime
*/
class BukuIndukSMA extends Model
{
    protected $connection   = 'nilai_sma_2017';
    protected $table        = 'bukuinduk';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;

    
}
