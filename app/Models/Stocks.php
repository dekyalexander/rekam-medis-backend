<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $fillable = [
        'qty',
        'drug_id',
        'location_id',
        'drug_expired_id',
        'created_at',
        'updated_at',
      ];

    public function drug(){
        return $this->belongsTo(Drug::class, 'id');
    }

    public function drugdistribution(){
        return $this->belongsTo(DrugDistribution::class, 'id','drug_id');
    }

    public function locationdrug(){
        return $this->belongsTo(LocationDrug::class, 'id');
    }

    public function drugexpired(){
        return $this->belongsTo(DrugExpired::class, 'id');
    }
}
