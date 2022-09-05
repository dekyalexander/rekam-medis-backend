<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugDistribution extends Model
{
    use HasFactory;
    protected $table = 'drug_distributions';
    protected $fillable = [
        'id',
	'drug_id',
        'drug_type_id',
        'drug_name_id',
        'drug_unit_id',
        'location_id',
        'drug_expired_id',
        'description',
        'qty',
        'created_at',
        'updated_at',
      ];

    public function drugtype(){
        return $this->hasOne(DrugType::class, 'id','drug_type_id');
    }
    public function drugname(){
        return $this->hasOne(DrugName::class, 'id','drug_name_id','location_id');
    }
    public function drugunit(){
        return $this->hasOne(DrugUnit::class, 'id','drug_unit_id');
    }
    public function drugexpired(){
        return $this->hasOne(DrugExpired::class, 'id','drug_expired_id');
    }
     public function locationdrug(){
        return $this->hasOne(LocationDrug::class, 'id','location_id');
    }
    public function listofukslocations(){
        return $this->hasOne(ListOfUKSLocations::class, 'id','location_id');
    }
}
