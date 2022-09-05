<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasTK extends Model
{
    protected $connection   = 'dbtk';
    protected $table        = 'tb_kelas';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public    $incrementing =  false;
      
}
