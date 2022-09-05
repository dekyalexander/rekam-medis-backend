<?php

namespace App\Services;
use App\Repositories\EmailRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EmailService{
    protected $emailRepository;

    public function __construct(EmailRepository $emailRepository){
	    $this->emailRepository = $emailRepository;
    }

    public function getstudentEmailOptions($filters){
        $data = $this->emailRepository->getstudentEmailOptions($filters)->get();
        $emails = [];
        foreach($data as $row){
           if($filters['jenjang_id'] === "4"){
                if($row->email!=''){
                    array_push($emails, $row->email);
                }
            }else{
                $check = null;
                if($row->parent_mother){
                    $check = $row->parent_mother->email ? $row->parent_mother->email : null ;
                }
                if($check){
                    if($row->parent_father){
                        $check = $row->parent_father->email ? $row->parent_father->email : null ;
                    }
                    
                }
                $parent_email = $row->email ? $row->email : $check;
                if($parent_email!=''){
                    array_push($emails, $parent_email);
                }
            }
        }
	    return $emails;
    }

    public function getemployeeEmailOptions($filters){
        $data = $this->emailRepository->getemployeeEmailOptions($filters)->get();
        $emails = [];
        foreach($data as $row){
            $contacs = $row->employeecontacts ? $row->employeecontacts->email : null;
            if($contacs !=''){
            array_push($emails, $contacs);
            }
        }
	    return $emails;
    }
        
}
