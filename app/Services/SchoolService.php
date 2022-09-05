<?php

namespace App\Services;
use App\Repositories\SchoolRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class SchoolService{
    protected $schoolRepository;

    public function __construct(SchoolRepository $schoolRepository){
	    $this->schoolRepository = $schoolRepository;
    }

    public function getSchoolsByFilters($filters){
	    return $this->schoolRepository
      ->getSchoolsByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->schoolRepository
      ->getSchoolsByFilters($filters)
      ->paginate($rowsPerPage);
    }

    public function getSchoolOptions($filters){
	    return $this->schoolRepository->getSchoolOptions($filters)->get();
    }

    public function createSchool($data){
      $this->schoolRepository->insertSchool($data);
  	}

    public function updateSchool($data, $id){
      $this->schoolRepository->updateSchool($data, $id);
    }

    public function deleteSchools($ids){
      $this->schoolRepository->deleteSchools($ids);          
    }
 
        
}
