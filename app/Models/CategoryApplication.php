<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'category_application';
    protected $fillable = [
        'name'
    ];
}
