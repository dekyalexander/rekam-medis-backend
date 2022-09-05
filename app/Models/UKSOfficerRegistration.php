<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UKSOfficerRegistration extends Model
{
    use HasFactory;
    protected $table = 'uks_officer_registrations';
    protected $fillable = [
      'name',  
      'job_location_id',
        'created_at',
        'updated_at',
      ];

    public function listofukslocations(){
        return $this->hasOne(ListOfUKSLocations::class, 'id','job_location_id');
    }

}
