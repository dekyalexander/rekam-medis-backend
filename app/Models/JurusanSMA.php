<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurusanSMA extends Model
{
    protected $connection   = 'nilai_sma_2017';
    protected $table        = 'mst_sma_jurusan';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
      
}
