<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSMPNisn extends Model
{
    protected $connection   = 'nilai_smp';
    protected $table        = 'ms_siswa_nisn';
    protected $primaryKey   = 'nis';
    protected $keyType      = 'string';
    public    $incrementing =  false;
  
}
