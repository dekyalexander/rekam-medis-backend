<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugUnit extends Model
{
    use HasFactory;
    protected $table = 'drug_units';
    protected $fillable = [
        'drug_unit',
        'created_at',
        'updated_at',
      ];

    public function drug(){
        return $this->belongsTo(Drug::class,'id', 'drug_unit_id');
    }

    public function drugdistribution(){
        return $this->belongsTo(DrugDistribution::class,'id', 'drug_id', 'drug_unit_id');
    }
}
