<?php

namespace App\Services;
use App\Repositories\UKSOfficerRegistrationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class UKSOfficerRegistrationService{
    protected $uksofficerregistrationRepository;

    public function __construct(UKSOfficerRegistrationRepository $uksofficerregistrationRepository){
	    $this->uksofficerregistrationRepository = $uksofficerregistrationRepository;
    }

    public function getListUKSLocationOptions($filters){
	    return $this->uksofficerregistrationRepository->getListUKSLocationOptions($filters)->get();
    }

    public function getUKSOfficerRegistrationOptions($filters, $rowsPerPage=25){
	    return $this->uksofficerregistrationRepository->getUKSOfficerRegistrationOptions($filters)->paginate($rowsPerPage);
    }

    public function createUKSOfficerRegistration($data){
      $this->uksofficerregistrationRepository->insert($data);
  	}

    // public function createUKSOfficerRegistration($data){
    //   if ($this->uksofficerregistrationRepository->getUKSOfficerRegistrationByCode($data['name'],$data['job_location_id']) < 1) {
    //     $this->uksofficerregistrationRepository->insert($data);
    //     return true;
    //   } else {
    //     return false;
    //   }   
  	// }

     public function updateUKSOfficerRegistration($data, $id){
      $this->uksofficerregistrationRepository->updateUKSOfficerRegistration($data, $id);
    }

    public function deleteUKSOfficerRegistration($ids){
      $this->uksofficerregistrationRepository->deleteUKSOfficerRegistration($ids);          
    }
        
}
