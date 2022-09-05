<?php

namespace App\Services;
use App\Repositories\DrugMutationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugMutationService{
    protected $drugMutationRepository;

    public function __construct(DrugMutationRepository $drugMutationRepository){
	    $this->drugMutationRepository = $drugMutationRepository;
    }

    // public function getDrugMutationOptions($filters){
	//     return $this->drugMutationRepository->getDrugMutationOptions($filters)->get();
    // }

    public function getDrugMutationOptions($filters, $rowsPerPage=25){
	    return $this->drugMutationRepository->getDrugMutationOptions($filters)->paginate($rowsPerPage);
    }

    public function createDataDrugMutation($data_drug){
        return $this->drugMutationRepository->insertDataDrugMutation($data_drug);
    }

    public function updateDataDrugMutation($data, $id){
        $this->drugMutationRepository->updateDataDrugMutation($data, $id);
    }

    public function deleteDrugMutation($ids){
        $this->drugMutationRepository->deleteDrugMutation($ids);          
      }
        
}
