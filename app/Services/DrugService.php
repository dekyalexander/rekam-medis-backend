<?php

namespace App\Services;
use App\Repositories\DrugRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class DrugService{
    protected $drugRepository;

    public function __construct(DrugRepository $drugRepository){
	    $this->drugRepository = $drugRepository;
    }

    // public function getListUKSLocationOptions($filters){
	//     return $this->drugRepository->getListUKSLocationOptions($filters)->get();
    // }

    // public function getLocationDrugOptions($filters){
	//     return $this->drugRepository->getLocationDrugOptions($filters);
    // }

    // List Distribution Medicine Service

    public function getDrugDistributionOptions($filters){
	    return $this->drugRepository->getDrugDistributionOptions($filters)->get();
    }

    // List First Stock Medicine Service

    public function getDrugOptions($filters, $rowsPerPage=25){
	    return $this->drugRepository->getDrugOptions($filters)->paginate($rowsPerPage);
    }

    public function getDrugDistributionSettings($filters, $rowsPerPage=25){
	    return $this->drugRepository->getDrugDistributionSettings($filters)->paginate($rowsPerPage);
    }

    public function createDataDrug($data_drug_name){
        return $this->drugRepository->insert($data_drug_name);
    }

    public function createDataExpiredDrug($data_expired_drug){
        return $this->drugRepository->insert2($data_expired_drug);
    }

    public function createDataLocationDrug($data_location_drug){
        return $this->drugRepository->insert3($data_location_drug);
    }

    public function createDataStockDrug($data_stock_drug){
        $this->drugRepository->insert4($data_stock_drug);
    }

    public function createDataDistributionDrug($data_distribution_drug){
        $this->drugRepository->insert5($data_distribution_drug);
    }

    public function createDrugDistributionSettings($data_distribution_drug){
        $this->drugRepository->createDrugDistributionSettings($data_distribution_drug);
    }


    // public function createDataDrug($data_drug_name){
    // if ($this->drugRepository->getDrugByCode($data_drug_name['drug_type_id'],$data_drug_name['drug_name_id'],$data_drug_name['drug_unit_id']) < 1) {
    //     return $this->drugRepository->insert($data_drug_name);
    //     return true;
    //   } else {
    //     return false;
    //   }   
        
    // }

    // public function createDataExpiredDrug($data_expired_drug){
    //     return $this->drugRepository->insert2($data_expired_drug);
    // }

    // public function createDataLocationDrug($data_location_drug){
    // if ($this->drugRepository->getDrugLocationByCode($data_location_drug['location_name']) < 1) {
    //     return $this->drugRepository->insert3($data_location_drug);
    //     return true;
    //   } else {
    //     return false;
    //   }  
        
    // }

    // public function createDataStockDrug($data_stock_drug){
    //     $this->drugRepository->insert4($data_stock_drug);
    // }

    public function updateData($data_drug_name, $id){
        $this->drugRepository->update($data_drug_name, $id);
    }

    public function updateData2($data_expired_drug, $id){
        $this->drugRepository->update2($data_expired_drug, $id);
    }

    public function updateData3($data_location_drug, $id){
        $this->drugRepository->update3($data_location_drug, $id);
    }

    public function updateData4($data_stock_drug, $id){
        $this->drugRepository->update4($data_stock_drug, $id);
    }


    public function updateDrugDistributionSettings($data_drug_distribution, $id){
        $this->drugRepository->updateDrugDistributionSettings($data_drug_distribution, $id);
    }

    // public function updateDataDrug($data, $id){
    //     $this->drugRepository->updateDataDrug($data, $id);
    // }


    public function deleteDrug($ids){
        $this->drugRepository->deleteDrug($ids);          
      }

      public function deleteDrugDistributionSettings($ids){
        $this->drugRepository->deleteDrugDistributionSettings($ids);          
      }
        
}
