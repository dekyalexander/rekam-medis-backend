<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSMPEdit extends Model
{
    protected $connection   = 'nilai_smp';
    protected $table        = 'ms_siswa_edit';
    protected $primaryKey   = 'nis';
    protected $keyType      = 'string';
    public    $incrementing =  false;
  
}
