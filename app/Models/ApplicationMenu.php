<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
  use HasFactory;

  protected $table = 'application_menus';

  protected $fillable = [
    'name',
    'ip',
    'host',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];
}
