<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasSMA extends Model
{
    protected $connection   = 'nilai_sma_2017';
    protected $table        = 'mst_sma_kelas';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
      
    public function jurusanSMA(){
        return $this->belongsTo('App\Models\JurusanSMA', 'jurusan');
    }
}
