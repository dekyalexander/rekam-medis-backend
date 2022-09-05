<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{

    use HasFactory;
    protected $connection   = 'pusat';
    protected $table="schools";
    
    protected $fillable = [
        'name',
        'code',
        'jenjang_id',
        'head_employee_id',
        'created_at',
        'update_at',
      ];
  
  
    public function jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'jenjang_id');
    }

    public function head_employee(){
        return $this->belongsTo('App\Models\Employee', 'head_employee_id');
      }
}
