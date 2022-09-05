<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
id	bigint(20) UN AI PK
jenjang_id	tinyint(4)
name	varchar(255)
code	varchar(20)
created_at	timestamp
updated_at	timestamp
*/

class Jurusan extends Model
{

    public function jenjang(){
        return $this->belongsTo('App\Models\Jenjang', 'jenjang_id');
    }
}
