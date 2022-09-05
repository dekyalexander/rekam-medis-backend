<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPCI extends Model
{
    protected $connection   = 'nilai_sma_2017';
    protected $table        = 'mst_sma_siswa';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
}
