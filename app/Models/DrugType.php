<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugType extends Model
{
    use HasFactory;
    protected $table = 'drug_types';
    protected $fillable = [
        'drug_type',
        'created_at',
        'updated_at',
      ];

      public function drug(){
        return $this->belongsTo(Drug::class,'id', 'drug_type_id');
    }

    public function drugdistribution(){
        return $this->belongsTo(DrugDistribution::class,'id', 'drug_id', 'drug_type_id');
    }
}
