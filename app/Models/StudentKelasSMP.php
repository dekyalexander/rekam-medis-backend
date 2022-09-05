<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentKelasSMP extends Model
{
    protected $connection   = 'nilai_smp';
    protected $table        = 'set_siswa_kelas';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
  
    public function kelasSMP(){
        return $this->belongsTo('App\Models\KelasSMP', 'kelas_id');
    }
}
