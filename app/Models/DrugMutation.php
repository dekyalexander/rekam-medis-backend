<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugMutation extends Model
{
    use HasFactory;
    protected $table = 'drug_mutations';
    protected $fillable = [
        'id',
        'drug_id',
        'location_id',
        'drug_expired_id',
        'qty',
        'created_at',
        'updated_at',
      ];

    public function drugdistribution(){
        return $this->belongsTo(DrugDistribution::class,'id', 'drug_id', 'location_id');
    }

    public function drugname(){
        return $this->belongsTo(DrugName::class,'drug_id','id');
    }

    public function locationdrug(){
        return $this->belongsTo(LocationDrug::class,'location_id','id');
    }

    public function listofukslocations(){
        return $this->belongsTo(ListOfUKSLocations::class,'location_id','id');
    }

}
