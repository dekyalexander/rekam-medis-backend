<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSMP extends Model
{
    protected $connection   = 'nilai_smp';
    protected $table        = 'ms_siswa';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
  
    public function siswaEdit()
    {
        return $this->hasOne(StudentSMPEdit::class, 'nis', 'nis');
    }

    public function siswaNisn()
    {
        return $this->hasOne(StudentSMPNisn::class, 'nis', 'nis');
    }

    public function siswaKelas()
    {
        return $this->hasOne(StudentKelasSMP::class, 'nis', 'nis');
    }
}
