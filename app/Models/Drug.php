<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;
    protected $table = 'drugs';
    protected $fillable = [
        'drug_name_id',
        'drug_type_id',
        'drug_unit_id',
        'location_id',
        'description',
        'created_at',
        'updated_at',
      ];
    
    public function drugtype(){
        return $this->hasOne(DrugType::class, 'id','drug_type_id');
    }
    public function drugname(){
        return $this->hasOne(DrugName::class, 'id','drug_name_id');
    }
    public function drugunit(){
        return $this->hasOne(DrugUnit::class, 'id','drug_unit_id');
    }
    public function drugexpired(){
        return $this->hasOne(DrugExpired::class, 'drug_id');
    }
    public function locationdrug(){
        return $this->hasOne(LocationDrug::class, 'drug_id');
    }
    public function stocks(){
        return $this->hasOne(Stocks::class, 'drug_id');
    }
}
