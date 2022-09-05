<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
id	bigint(20) UN AI PK
name	varchar(255)
start_date	date
end_date	date
is_active	tinyint(4)
created_at	timestamp
updated_at	timestamp
*/
class TahunPelajaran extends Model {
    use HasFactory;
    protected $connection   = 'pusat';
    protected $table="tahun_pelajarans";
     protected $fillable = [
        'start_date',
        'name',
        'end_date',
        'is_active',
        'created_at',
        'update_at',
      ];
      
    public function studentmcu(){
        return $this->hasOne(StudentMCU::class, 'student_id');
    }

    public function student(){
        return $this->hasOne(Student::class, 'id');
    }
    
}
