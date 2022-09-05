<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationCategories extends Model
{
    use HasFactory;

    protected $table = "application_categories";
    protected $fillable = [
        'application_id',
        'category_id'
    ];

    public function applications()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryApplication::class, 'category_id', 'id');
    }
}
