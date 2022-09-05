<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugExpired extends Model
{
    use HasFactory;
    protected $table = 'drug_expireds';
    protected $fillable = [
        'date_expired',
        'drug_id',
        'created_at',
        'updated_at',
      ];
    
    public function drug(){
        return $this->belongsTo(Drug::class, 'id');
    }
    public function drugdistribution(){
        return $this->belongsTo(DrugDistribution::class, 'id','drug_expired_id');
    }
     public function stocks(){
        return $this->belongsTo(Stocks::class, 'id');
    }
}
