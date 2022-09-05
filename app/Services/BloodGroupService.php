<?php

namespace App\Services;
use App\Repositories\BloodGroupRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class BloodGroupService{
    protected $bloodgroupRepository;

    public function __construct(BloodGroupRepository $bloodgroupRepository){
	    $this->bloodgroupRepository = $bloodgroupRepository;
    }

    public function getBloodGroupOptions($filters){
	    return $this->bloodgroupRepository->getBloodGroupOptions($filters)->get();
    }
        
}
