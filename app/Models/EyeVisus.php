<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EyeVisus extends Model
{
    use HasFactory;
    protected $table = 'eye_visus';
    protected $fillable = [
        'od',
        'os',
        'created_at',
        'updated_at',
      ];
}
