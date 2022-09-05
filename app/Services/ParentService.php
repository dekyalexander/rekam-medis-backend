<?php

namespace App\Services;
use App\Repositories\ParentRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class ParentService{
    protected $studentRepository;
    protected $parentRepository;

    public function __construct(ParentRepository $parentRepository, StudentRepository $studentRepository){
	    $this->parentRepository = $parentRepository;
      $this->studentRepository = $studentRepository;
    }

    public function getParentsByFilters($filters){
	    return $this->parentRepository
      ->getParentsByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    return $this->parentRepository
      ->getParentsByFilters($filters)      
      ->paginate($rowsPerPage);
    }

    public function getParentOptions($filters){
	    return $this->parentRepository->getParentOptions($filters)
      ->limit(10)->get();
    }

    public function getStudentsOfParent($parent_id){          
      return $this->studentRepository->getStudentsByParentId($parent_id)->get();
    }

    public function getParentDetail($parent_id){
	    return $this->parentRepository->getParentDetail($parent_id)->first();
    }

    public function addStudentsToParent($parent_id, $sex_type_value, $student_ids){    
      $students = $this->studentRepository->getStudentInIds($student_ids)->get();
      foreach ($students as $student) {
        if(
          $student->father_parent_id !== $parent_id && 
          $student->mother_parent_id !== $parent_id
          )
          {
            if($sex_type_value===1){
              $this->studentRepository->updateStudent(['father_parent_id'=>$parent_id], $student->id);
            }else if($sex_type_value===2){
              $this->studentRepository->updateStudent(['mother_parent_id'=>$parent_id], $student->id);
            }
            
          }
      }
      
      return $this->studentRepository->getStudentsByParentId($parent_id)->get();
    }

    public function createParent($data){
      $this->parentRepository->insertParent($data);
  	}   

    public function updateParent($data, $id){
      $this->parentRepository->updateParent($data, $id);
    }

    public function deleteParents($ids){
      $this->parentRepository->deleteParents($ids);          
    }
 
        
}
