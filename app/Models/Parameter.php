<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $connection   = 'pusat';

    protected $table = 'parameters';

    protected $fillable = [
        'code',
        'name',
        'group',
        'value',
        'description',
        'owner_user_id',
        'owner_role_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student(){
        return $this->hasOne(Student::class, 'id');
    }
}
