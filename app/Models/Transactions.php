<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'drug_id',
        'location_id',
        'date_expired',
        'qty_take',
        'leftover_qty',
        'description',
        'created_at',
        'updated_at',
      ];

    public function drugname(){
        return $this->hasOne(DrugName::class, 'id','drug_id');
    }

    public function listofukslocations(){
        return $this->hasOne(ListOfUKSLocations::class, 'id','location_id');
    }
}
