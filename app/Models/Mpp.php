<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpp extends Model
{
    use HasFactory;
    protected $table = 'mpp_informations';
    protected $fillable = [
        'tahun_pelajaran',
        'validity_period_from',
        'validity_period_until',
        'description_1',
        'publish',
        'user_created_id'
    ];
}
