<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
id	bigint(20) UN AI PK
user_id	bigint(20)
name	varchar(50)
ktp	varchar(20)
nkk	varchar(20)
email	varchar(50)
mobilePhone	varchar(20)
birth_date	date
sex_type_value	tinyint(4)
parent_type_value	tinyint(4)
wali_type_value	tinyint(4)
job	varchar(255)
jobCorporateName	varchar(50)
jobPositionName	varchar(30)
jobWorkAddress	varchar(255)
address	text
provinsi_id	tinyint(4)
kota_id	tinyint(4)
kecamatan_id	int(11)
kelurahan_id	int(11)
created_at	timestamp
updated_at	timestamp
*/
class Parents extends Model
{
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function sex_type(){
        return $this->belongsTo('App\Models\Parameter', 'sex_type_value','value')->where('group','sex_type');
    }

    public function parent_type(){
        return $this->belongsTo('App\Models\Parameter', 'parent_type_value','value')->where('group','parent_type');
    }

    public function wali_type(){
        return $this->belongsTo('App\Models\Parameter', 'wali_type_value','value')->where('group','wali_type');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'id');
    }
    
}
