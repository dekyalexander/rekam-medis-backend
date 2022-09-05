<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationDrug extends Model
{
    use HasFactory;
    protected $table = 'location_drugs';
    protected $fillable = [
        'location_id',
        'drug_id',
        'created_at',
        'updated_at',
      ];

     public function stocks(){
        return $this->hasOne(Stocks::class, 'stock_id');
    }
    public function drug(){
        return $this->belongsTo(Drug::class, 'id','location_id');
    }

    public function listofukslocations(){
        return $this->hasOne(ListOfUKSLocations::class, 'id','location_id');
    }
}
