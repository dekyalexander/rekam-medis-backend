<?php

namespace App\Services;
use App\Repositories\StudentRepository;
use App\Repositories\ParentRepository;
use App\Repositories\TahunPelajaranRepository;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\JenjangRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\KelasRepository;
use App\Repositories\ParallelRepository;
use App\Repositories\ParameterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class StudentService{
  
    protected $studentRepository;
    protected $parentRepository;
    protected $tahunPelajaranRepository;
    protected $userRepo;
    protected $roleRepository;
    protected $jenjangRepository;
    protected $schoolRepository;
    protected $kelasRepository;
    protected $parallelRepository;
    protected $parameterRepository;
    protected $jenjang;
    protected $school;
    protected $tahunActive;
    protected $monthNames = [
      'Januari'=>1,
      'Februari'=>2,
      'Maret'=>3,
      'April'=>4,
      'Mei'=>5,
      'Juni'=>6,
      'Juli'=>7,
      'Agustus'=>8,
      'September'=>9,
      'Oktober'=>10,
      'November'=>11,
      'Desember'=>12
    ];
    

    public function __construct(ParameterRepository $parameterRepository, ParallelRepository $parallelRepository, KelasRepository $kelasRepository, SchoolRepository $schoolRepository, JenjangRepository $jenjangRepository, ParentRepository $parentRepository,  RoleRepository $roleRepository, UserRepository $userRepository, TahunPelajaranRepository $tahunPelajaranRepository, StudentRepository $studentRepository){
	    $this->parentRepository = $parentRepository;
      $this->userRepository = $userRepository;
      $this->tahunPelajaranRepository = $tahunPelajaranRepository;
      $this->studentRepository = $studentRepository;
      $this->roleRepository = $roleRepository;
      $this->jenjangRepository = $jenjangRepository;
      $this->schoolRepository = $schoolRepository;
      $this->kelasRepository = $kelasRepository;
      $this->parallelRepository = $parallelRepository;
      $this->parameterRepository = $parameterRepository;
    }

    public function getStudentsByFilters($filters){
	    return $this->studentRepository
      ->getStudentsByFilters($filters)
      ->get();
    }

    public function getByFiltersPagination($filters, $rowsPerPage=25){
	    if(isset($filters['is_sibling'])){
        return $this->getStudentWithSiblings($this->studentRepository->getStudentsByFilters($filters), $rowsPerPage);
      }else{
        return $this->studentRepository->getStudentsByFilters($filters)->paginate($rowsPerPage);
      }                  
    }

    public function getStudentWithSiblings($students, $rowsPerPage){
	    $studentsPaginate = $students->paginate($rowsPerPage);
      foreach ($studentsPaginate as $student) {
        $siblingDuplicates = $student->siblings_from_father
                            ->merge($student->siblings_from_mother)
                            ->merge($student->siblings_from_kk);        
        $siblings = collect();
        foreach ($siblingDuplicates as $sibling) {                    
          if($sibling->id !== $student->id){
            $siblings->push($sibling);  
          }
        }
        $student->sibling_students = $siblings;
        
      }
      return $studentsPaginate;
    }

    public function getStudentOptions($filters){
	    return $this->studentRepository->getStudentOptions($filters)
      ->get();
    }

    public function getStudentDetail($student_id){
	    return $this->studentRepository->getStudentDetail($student_id)->first();
    }

    public function getParentsOfStudent($student_id){
	    return $this->parentRepository->getParentsByStudentId($student_id)->get();
    }

    public function getMutationsOfStudent($niy){
	    return $this->studentRepository->getMutationsOfStudent($niy)->get();
    }    

    public function getSiblingsOfStudent($niy){
      $student = $this->studentRepository->getStudentByNIY($niy)->first();
      return $this->studentRepository->getSiblingByParentsId($niy, $student->father_parent_id, $student->mother_parent_id)->get();      
      
    }

    public function createStudent($data){
      $this->studentRepository->insertStudent($data);
  	}   

    public function updateStudent($data, $id){
      $this->studentRepository->updateStudent($data, $id);
    }

    public function saveStudentMutation(){ 
      $students = $this->studentRepository->getStudentsByJenjang($this->jenjang->id)->get();
      foreach ($students as $student) {
            $dataMutation = [
              'jenjang_id'=>$student->jenjang_id,
              'school_id'=>$student->school_id,
              'kelas_id'=>$student->kelas_id,
              'parallel_id'=>$student->parallel_id,
              'tahun_pelajaran_id'=>$this->tahunActive->id,
              'nis'=> $student->nis,
              'niy'=> $student->niy,        
              'nkk'=> $student->nkk,
              'photo'	=> $student->photo,
              'is_active'	=> $student->is_active 
            ];
            
            $studentMutation = $this->studentRepository->getStudentMutationNiyYear($student->niy,$this->tahunActive->id)->first();
            if($studentMutation){
              $this->studentRepository->updateStudentMutation($dataMutation,$studentMutation->id);
            }else{
              $this->studentRepository->insertStudentMutation($dataMutation);
            }
          }
    }

    public function syncStudentTK($tahun_pelajaran_id){      
      
      set_time_limit(0);
      $father_parent_id = null;
      $mother_parent_id = null;
      $this->jenjang = $this->jenjangRepository->getJenjangByCode('TK')->first();
      $this->school = $this->schoolRepository->getSchoolByJenjang($this->jenjang->id)->first();
      if(isset($tahun_pelajaran_id)){        
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranById($tahun_pelajaran_id)->first();
      }else{
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      }      
      $roleStudent = $this->roleRepository->getRoleByCode('STUDENT')->first();
      $roleParent = $this->roleRepository->getRoleByCode('PARENT')->first();
      $existingStudents = $this->studentRepository->getAllStudents()->pluck('niy');
      $existingUsers = $this->userRepository->getAllUsers()->pluck('username')->all();      
      $studentTKs = $this->studentRepository->getStudentWithBukuIndukTK($this->tahunActive->name)->get();     
      
      //F81204004
      $test = [];

      
      foreach ($studentTKs as $studentTK) {                  
        
        $dataStudent = $this->mapStudentTKToStudent($studentTK);
        $kelas = $this->kelasRepository->getKelasByNameAndJenjangId(trim($studentTK->level), $this->jenjang->id)->first();      
        $parallel = null;  
        if($kelas){
          $parallel = $this->parallelRepository->getParallelByNameAndKelasId(trim($studentTK->kelas), $kelas->id)->first();        
        }          
        $kkAyah = $studentTK->bukuInduk->no_kartu_keluarga===""||$studentTK->bukuInduk->no_kartu_keluarga==="0" ? null : $studentTK->bukuInduk->no_kartu_keluarga;
        $ktpAyah = $studentTK->bukuInduk->no_ktp_ayah===""||$studentTK->bukuInduk->no_ktp_ayah==="0" ? null : $studentTK->bukuInduk->no_ktp_ayah;
        $emailAyah = $studentTK->bukuInduk->email_ayah===""||$studentTK->bukuInduk->email_ayah==="-" ? null : $studentTK->bukuInduk->email_ayah;
        $mobilePhoneAyah = $studentTK->bukuInduk->hp_ayah===""||$studentTK->bukuInduk->hp_ayah==="0" ? null : $studentTK->bukuInduk->hp_ayah;

        $kkIbu = $studentTK->bukuInduk->no_kartu_keluarga===""||$studentTK->bukuInduk->no_kartu_keluarga==="0" ? null : $studentTK->bukuInduk->no_kartu_keluarga;
        $ktpIbu = $studentTK->bukuInduk->no_ktp_ibu===""||$studentTK->bukuInduk->no_ktp_ibu==="0" ? null : $studentTK->bukuInduk->no_ktp_ibu;
        $emailIbu = $studentTK->bukuInduk->email_ibu===""||$studentTK->bukuInduk->email_ibu==="-" ? null : $studentTK->bukuInduk->email_ibu;
        $mobilePhoneIbu = $studentTK->bukuInduk->hp_ibu===""||$studentTK->bukuInduk->hp_ibu==="0" ? null : $studentTK->bukuInduk->hp_ibu;
        
        //$existingFather = $this->parentRepository->getExistingParentByIdentity($ktpAyah, $kkAyah,1)->first();
        $existingFather=null;

        if($ktpAyah !== null ){
          $existingFather = $this->parentRepository->getExistingParentByKtp($ktpAyah,1)->first();
        }
        if($existingFather===null && $kkAyah !== null){
          $existingFather = $this->parentRepository->getExistingParentByKk($kkAyah,1)->first();
        }
        
        $existingMother=null;
            
        if($ktpIbu !== null ){
          $existingMother = $this->parentRepository->getExistingParentByKtp($ktpIbu,2)->first();
        }
        if($existingMother===null && $kkIbu !== null){
          $existingMother = $this->parentRepository->getExistingParentByKk($kkIbu,2)->first();
        } 

        //father
        if ($existingFather) {
          $father_parent_id = $existingFather->id;
          $dataStudent['is_sibling_student'] = 1;
        } else{
          if (!in_array('F'.$studentTK->nis, $existingUsers)) {
            $user_father_id = $this->userRepository->insertUserGetId(
              [
                'name'=>$studentTK->bukuInduk->nama_ayah,
                'email'=>$emailAyah,
                'username'=>'F'.$studentTK->nis,
                'password'=>bcrypt('F'.$studentTK->nis),
                'user_type_value'=>3
              ]
            );
            $dataFather = $this->mapStudentTKToFather($studentTK);
            $dataFather['user_id'] = $user_father_id;
            $dataFather['ktp']= $ktpAyah;
            $dataFather['nkk']=  $kkAyah;
            $dataFather['email']=$emailAyah;
            $dataFather['mobilePhone']= $mobilePhoneAyah;
                  
            
            $father_parent_id = $this->parentRepository->insertParentGetId($dataFather);  
            $this->roleRepository->syncUserRole($user_father_id, $roleParent->id);
            array_push($existingUsers,'F'.$studentTK->nis);
          }
          
        }  
        
        
        //mother
        if ($existingMother) {
          $mother_parent_id = $existingMother->id;
          $dataStudent['is_sibling_student'] = 1;
        } else{
          if (!in_array('M'.$studentTK->nis, $existingUsers)) {
            $user_mother_id = $this->userRepository->insertUserGetId(
              [
                'name'=>$studentTK->bukuInduk->nama_ibu,
                'email'=>$emailIbu,
                'username'=>'M'.$studentTK->nis,
                'password'=>bcrypt('M'.$studentTK->nis),
                'user_type_value'=>3
              ]
            );
  
            $dataMother = $this->mapStudentTKToMother($studentTK);
            $dataMother['user_id'] = $user_mother_id;        
            $dataMother['ktp']= $ktpIbu;
            $dataMother['nkk']=  $kkIbu;
            $dataMother['email']=$emailIbu;
            $dataMother['mobilePhone']= $mobilePhoneIbu;  
            
            $mother_parent_id = $this->parentRepository->insertParentGetId($dataMother);  
            $this->roleRepository->syncUserRole($user_mother_id, $roleParent->id);
            array_push($existingUsers,'M'.$studentTK->nis);
          }
          
        }  
          
                

        //student
        if (!in_array($studentTK->nis, $existingUsers)) {
          $user_student_id = $this->userRepository->insertUserGetId(
            [
              'name'=>$studentTK->nama,
              'username'=>$studentTK->nis,
              'password'=>bcrypt($studentTK->nis),
              'user_type_value'=>2
            ]
          );
          
          
          $dataStudent['user_id'] = $user_student_id;
          $dataStudent['father_ktp'] = $ktpAyah;
          $dataStudent['mother_ktp'] = $ktpIbu;          
          $dataStudent['father_parent_id'] = $father_parent_id;
          $dataStudent['mother_parent_id'] = $mother_parent_id;                             
          $dataStudent['jenjang_id'] = $this->jenjang->id;    
          $dataStudent['school_id'] = $this->school->id;    
          $dataStudent['kelas_id'] = $kelas? $kelas->id : null;    
          $dataStudent['parallel_id'] = $parallel? $parallel->id : null;    
          
          $this->studentRepository->insertStudent($dataStudent);  
          $this->roleRepository->syncUserRole($user_student_id, $roleStudent->id);
          array_push($existingUsers,$studentTK->nis);

        }else{

          $dataStudent =[
            'jenjang_id'=>$this->jenjang->id,
            'school_id'=>$this->school->id,
            'kelas_id'=>$kelas? $kelas->id : null,
            'parallel_id'=>$parallel? $parallel->id : null
          ];      
              
          $this->studentRepository->updateStudentByNIY($dataStudent, $studentTK->nis);
            
        }

          
      }
      //array_push($test,$this->mapStudentTKToFather($studentTK));          

      //return $test;

      $this->saveStudentMutation();


      return ['message'=>'success'];

      
      
            
    }

    
    public function mapStudentTKToStudent($studentTK){      
      $kelas = $this->kelasRepository->getKelasByNameAndJenjangId(trim($studentTK->level), $this->jenjang->id)->first();      
      $parallel = null;

      if($kelas){
        $parallel = $this->parallelRepository->getParallelByNameAndKelasId(trim($studentTK->kelas), $kelas->id)->first();        
      }
      
      /*
      return[
        'sex_type_value'	=> $studentTK->bukuInduk ? ($studentTK->bukuInduk->jen_kel === 'Perempuan' ? 2 : 1):null
      ];
      */      

      return[
        'kelas_id'=> $kelas? $kelas->id : null,
        'parallel_id'=> $parallel? $parallel->id : null,        
        'name'=> $studentTK->nama,
        'nis'=> $studentTK->nis,
        'niy'=> $studentTK->nis,        
        'nkk'=> $studentTK->bukuInduk->no_kartu_keluarga,
        'sex_type_value'	=> $studentTK->bukuInduk->jen_kel === 'Perempuan' ? 2 : 1,
        'address'	=> $studentTK->bukuInduk->alamat,
        'kodepos'	=> $studentTK->bukuInduk->kodepos,
        'birth_place'	=> $studentTK->tmp_lahir,
        'birth_date'	=> $studentTK->tgl_lahir,
        'birth_order'	=> $studentTK->bukuInduk->anak_keberapa,
        'nationality'	=> $studentTK->bukuInduk->warga_negara,
        'is_active'	=> $studentTK->active ?  $studentTK->active : 0,         
        //'masuk_tahun_id'	=> null,
        //'masuk_jenjang_id'	=> null,
        //'masuk_kelas_id'	=> null,
        //'is_father_alive'	=> 1,
        //'is_mother_alive'	=> 1,
        //'is_poor'	=> 0,
        //'nisn'	=> $studentSD->coverRapotSD->nisn,
        //'email'	=> null,
        //'kota'	=> null,
        //'kecamatan'	=> null,
        //'kelurahan'	=> null,
        //'photo'	=> null,
        //'handphone'	=> null,
        //'religion_value'	=> 0,
        //'language'	=> null,
        //'is_adopted'	=> 0,
        //'stay_with_value'	=> 1,
        //'siblings'	=> $studentSD->studentSiswaSD->jumlahSaudara,
        //'is_sibling_student'	=> 0,
        //'foster'	=> 0,
        //'step_siblings'	=> 0,
        //'medical_history'	=> null,
        //'student_status_value'	=> 1,
        //'lulus_tahun_id'	=> null,
        //'tahun_lulus'	=> null,
        //'gol_darah'	=> null,
        'is_cacat'	=> 0,
        //'tinggi'	=> 0,
        //'berat'	=> 0,
        //'sekolah_asal'	=> $studentSD->studentSiswaSD->sekolahAsal
      ];
    }
    
    public function mapStudentTKToFather($studentTK){      
      return[
        'name'=>$studentTK->bukuInduk->nama_ayah,
        'birth_date'=> '1890-01-01',
        'sex_type_value'=> 1,
        'parent_type_value'=> 1,
        'wali_type_value'=> null,
        'job'=> $studentTK->bukuInduk->pekerjaan_ayah,   
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> ''     
      ];
      
    }

    public function mapStudentTKToMother($studentTK){      
      return[
        'name'=>$studentTK->bukuInduk->nama_ibu,
        'birth_date'=> '1890-01-01',
        'sex_type_value'=> 2,
        'parent_type_value'=> 2,
        'wali_type_value'=> null,
        'job'=> $studentTK->bukuInduk->pekerjaan_ibu,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> '' 
      ];
    }

    public function syncStudentSD($tahun_pelajaran_id){
        
          set_time_limit(0);
          $father_parent_id = null;
          $mother_parent_id = null;
          $this->jenjang = $this->jenjangRepository->getJenjangByCode('SD')->first();
          $this->school = $this->schoolRepository->getSchoolByJenjang($this->jenjang->id)->first();
          if(isset($tahun_pelajaran_id)){        
            $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranById($tahun_pelajaran_id)->first();
          }else{
            $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
          }      
          $roleStudent = $this->roleRepository->getRoleByCode('STUDENT')->first();
          $roleParent = $this->roleRepository->getRoleByCode('PARENT')->first();
          $existingStudents = $this->studentRepository->getAllStudents()->pluck('niy');
          $existingUsers = $this->userRepository->getAllUsers()->pluck('username')->all();      
          $studentSDs = $this->studentRepository
          ->getStudentSDWithBukuInduk(str_replace("-","/",$this->tahunActive->name))->get();     
      
          $studentKelasSDs = $this->studentRepository->getStudentKelasSD($this->tahunActive->name)->get();
          
          
          $test = [];
      /*
          foreach ($studentKelasSDs as $studentKelasSD) { 
            $parallel = $this->parallelRepository->getParallelByNameAndJenjangId(trim($studentKelasSD->kelas), $this->jenjang->id)->first();                     
            if($parallel){
              $data = [
                'kelas_id'=> $parallel->kelas_id,
                'parallel_id'=> $parallel->id
              ];
              $this->studentRepository->updateStudentByNIS($data,$studentKelasSD->nis);
            }     
            array_push($test,$parallel);      

          }
          
    
          return $test;

      */    
          foreach ($studentSDs as $studentSD) {                          
            $dataStudent = $this->mapStudentSDToStudent($studentSD);
            $kkAyah = null;
            //$kkAyah = $studentSD->bukuInduk->no_kartu_keluarga===""||$studentSD->bukuInduk->no_kartu_keluarga==="0" ? null : $studentSD->bukuInduk->no_kartu_keluarga;
            $ktpAyah = $studentSD->studentSiswaSD->ktpAyah===""||$studentSD->studentSiswaSD->ktpAyah==="0" ? null : $studentSD->studentSiswaSD->ktpAyah;
            $emailAyah = $studentSD->studentSiswaSD->email===""? null : $studentSD->studentSiswaSD->email;
            $mobilePhoneAyah = $studentSD->studentSiswaSD->hp===""||$studentSD->studentSiswaSD->hp==="0" ? null : $studentSD->studentSiswaSD->hp;
            
            $kkIbu=null;
            //$kkIbu = $studentSD->bukuInduk->no_kartu_keluarga===""||$studentSD->bukuInduk->no_kartu_keluarga==="0" ? null : $studentSD->bukuInduk->no_kartu_keluarga;
            $ktpIbu = $studentSD->studentSiswaSD->ktpIbu===""||$studentSD->studentSiswaSD->ktpIbu==="0" ? null : $studentSD->studentSiswaSD->ktpIbu;
            $emailIbu = $studentSD->studentSiswaSD->email===""? null : $studentSD->studentSiswaSD->email;
            $mobilePhoneIbu = $studentSD->studentSiswaSD->hpibu===""||$studentSD->studentSiswaSD->hpibu==="0" ? null : $studentSD->studentSiswaSD->hpibu;
        
            $existingFather=null;

            if($ktpAyah !== null ){
              $existingFather = $this->parentRepository->getExistingParentByKtp($ktpAyah,1)->first();
            }
            if($existingFather===null && $emailAyah !== null ){
            //  $existingFather = $this->parentRepository->getExistingParentByEmail($emailAyah,1)->first();
            }
            if($existingFather===null && $mobilePhoneAyah !== null){
              //$existingFather = $this->parentRepository->getExistingParentByMobilePhone($mobilePhoneAyah,1)->first();
            }
            if($existingFather===null && $kkAyah !== null){
              $existingFather = $this->parentRepository->getExistingParentByKk($kkAyah,1)->first();
            }
                  
            
            $existingMother=null;
            
            if($ktpIbu !== null ){
              $existingMother = $this->parentRepository->getExistingParentByKtp($ktpIbu,2)->first();
            }
            if($existingMother===null && $emailIbu !== null ){
              //$existingMother = $this->parentRepository->getExistingParentByEmail($emailIbu,2)->first();
            }
            if($existingMother===null && $mobilePhoneIbu !== null){
              //$existingMother = $this->parentRepository->getExistingParentByMobilePhone($mobilePhoneIbu,2)->first();
            }
            if($existingMother===null && $kkIbu !== null){
              $existingMother = $this->parentRepository->getExistingParentByKk($kkIbu,2)->first();
            }                        

            //array_push($test,$existingMother);
            //continue;
            //father
            if ($existingFather) {
              $father_parent_id = $existingFather->id;
              $dataStudent['is_sibling_student'] = 1;
            } else{
              if (!in_array('F'.$studentSD->nomorIndukSiswa, $existingUsers)) {
                $user_father_id = $this->userRepository->insertUserGetId(
                  [
                    'name'=>$studentSD->studentSiswaSD->namaAyah,
                    'email'=>$emailAyah,
                    'username'=>'F'.$studentSD->nomorIndukSiswa,
                    'password'=>bcrypt('F'.$studentSD->nomorIndukSiswa),
                    'user_type_value'=>3
                  ]
                );
                $dataFather = $this->mapStudentSDToFather($studentSD);
                $dataFather['user_id'] = $user_father_id;          
                $dataFather['ktp']= $ktpAyah;
                $dataFather['nkk']=  $kkAyah;
                $dataFather['email']=$emailAyah;
                $dataFather['mobilePhone']= $mobilePhoneAyah;
                
                $father_parent_id = $this->parentRepository->insertParentGetId($dataFather);  
                $this->roleRepository->syncUserRole($user_father_id, $roleParent->id);
                array_push($existingUsers,'F'.$studentSD->nomorIndukSiswa);
              }
              
            }  
            
            
            //mother
            if ($existingMother) {
              $mother_parent_id = $existingMother->id;
              $dataStudent['is_sibling_student'] = 1;
            } else{
              if (!in_array('M'.$studentSD->nomorIndukSiswa, $existingUsers)) {
                $user_mother_id = $this->userRepository->insertUserGetId(
                  [
                    'name'=>$studentSD->studentSiswaSD->namaIbu,
                    'email'=>$emailIbu,
                    'username'=>'M'.$studentSD->nomorIndukSiswa,
                    'password'=>bcrypt('M'.$studentSD->nomorIndukSiswa),
                    'user_type_value'=>3
                  ]
                );
      
                $dataMother = $this->mapStudentSDToMother($studentSD);
                $dataMother['user_id'] = $user_mother_id;      
                $dataMother['ktp']= $ktpIbu;
                $dataMother['nkk']=  $kkIbu;
                $dataMother['email']=$emailIbu;
                $dataMother['mobilePhone']= $mobilePhoneIbu;    
                
                $mother_parent_id = $this->parentRepository->insertParentGetId($dataMother);  
                $this->roleRepository->syncUserRole($user_mother_id, $roleParent->id);
                array_push($existingUsers,'M'.$studentSD->nomorIndukSiswa);
              }
              
            }  
                                      
    
            //student
            if (!in_array($studentSD->nomorIndukSiswa, $existingUsers)) {
              $user_student_id = $this->userRepository->insertUserGetId(
                [
                  'name'=>$studentSD->coverRapotSD->nama_siswa,
                  'username'=>$studentSD->nomorIndukSiswa,
                  'password'=>bcrypt($studentSD->nomorIndukSiswa),
                  'user_type_value'=>2
                ]
              );
              
              
              $dataStudent['user_id'] = $user_student_id;
              $dataStudent['father_ktp'] = $ktpAyah;
              $dataStudent['mother_ktp'] = $ktpIbu;          
              $dataStudent['father_parent_id'] = $father_parent_id;
              $dataStudent['mother_parent_id'] = $mother_parent_id;                             
              $dataStudent['jenjang_id'] = $this->jenjang->id;    
              $dataStudent['school_id'] = $this->school->id;              
              
              $this->studentRepository->insertStudent($dataStudent);  
              $this->roleRepository->syncUserRole($user_student_id, $roleStudent->id);
              array_push($existingUsers,$studentSD->nomorIndukSiswa);
    
            }else{
    /*
              $kelas = $this->kelasRepository->getKelasByNameAndJenjangId(trim($studentSD->level), $this->jenjang->id)->first();      
              $parallel = null;
        
              if($kelas){
                $parallel = $this->parallelRepository->getParallelByNameAndKelasId(trim($studentSD->kelas), $kelas->id)->first();        
              }
    
              $dataStudent =[
                'jenjang_id'=>$this->jenjang->id,
                'school_id'=>$this->school->id,
                'kelas_id'=>$kelas? $kelas->id : null,
                'parallel_id'=>$parallel? $parallel->id : null
              ];      
                  
              $this->studentRepository->updateStudentByNIY($dataStudent, $studentSD->nis);
      */          
            }
              
          }

          //update kelas, parallel
          foreach ($studentKelasSDs as $studentKelasSD) { 
            //array_push($test,$studentKelasSD->nis); continue;
            $parallel = $this->parallelRepository->getParallelByNameAndJenjangId(trim($studentKelasSD->kelas), $this->jenjang->id)->first();                     
            if($parallel){
              $data = [
                'kelas_id'=> $parallel->kelas_id,
                'parallel_id'=> $parallel->id
              ];
              $this->studentRepository->updateStudentByNIS($data,$studentKelasSD->nis);
              
            }            

          }

          $this->saveStudentMutation();
          
          //return $test;
                        
          return ['message'=>'success'];
    
          
            
    }

    public function mapStudentSDToStudent($studentSD){      
      
      return[
        //'kelas_id'=> null,
        //'parallel_id'=> null,        
        //'masuk_tahun_id'	=> null,
        //'masuk_jenjang_id'	=> null,
        //'masuk_kelas_id'	=> null,
        //'is_father_alive'	=> 1,
        //'is_mother_alive'	=> 1,
        //'is_poor'	=> 0,
        'name'=> $studentSD->coverRapotSD->nama_siswa,
        'nis'=> $studentSD->coverRapotSD->nis,
        'niy'=> $studentSD->nomorIndukSiswa,        
        'nisn'	=> $studentSD->coverRapotSD->nisn,
        //'nkk'=> ,
        'father_ktp'	=> $studentSD->studentSiswaSD->ktpAyah,
        'mother_ktp'	=> $studentSD->studentSiswaSD->ktpIbu,
        //'email'	=> null,
        'sex_type_value'	=> strcasecmp($studentSD->studentSiswaSD->jenisKelamin, "Laki-laki") ? 1 : 2,
        'address'	=> $studentSD->studentSiswaSD->alamat,
        //'kota'	=> null,
        //'kecamatan'	=> null,
        //'kelurahan'	=> null,
        'kodepos'	=> $studentSD->studentSiswaSD->kodepos,
        //'photo'	=> null,
        //'handphone'	=> null,
        'birth_place'	=> $studentSD->studentSiswaSD->tmpLahir,
        'birth_date'	=> $studentSD->studentSiswaSD->thnLahir."-".$this->monthNames[$studentSD->studentSiswaSD->blnLahir]."-".$studentSD->studentSiswaSD->tglLahir,
        'birth_order'	=> $studentSD->studentSiswaSD->anakKe,
        //'religion_value'	=> 0,
        'nationality'	=> $studentSD->studentSiswaSD->warganegara,
        //'language'	=> null,
        //'is_adopted'	=> 0,
        //'stay_with_value'	=> 1,
        'siblings'	=> $studentSD->studentSiswaSD->jumlahSaudara,
        //'is_sibling_student'	=> 0,
        //'foster'	=> 0,
        //'step_siblings'	=> 0,
        //'medical_history'	=> null,
        'is_active'	=> 1,
        'student_status_value'	=> 1,
        //'lulus_tahun_id'	=> null,
        //'tahun_lulus'	=> null,
        //'gol_darah'	=> null,
        'is_cacat'	=> 0,
        //'tinggi'	=> 0,
        //'berat'	=> 0,
        'sekolah_asal'	=> $studentSD->studentSiswaSD->sekolahAsal
      ];
    }
    
    public function mapStudentSDToFather($studentSD){      
      return[
        'name'=> $studentSD->studentSiswaSD->namaAyah,
        //'birth_date'=> '1890-01-01',
        'sex_type_value'=> 1,
        'parent_type_value'=> 1,
        //'wali_type_value'=> null,
        'job'=> $studentSD->studentSiswaSD->pekerjaanAyah,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> '',
        //'ktp'=> '',
        //'nkk'=> '',
        //'email'=> '',
        //'mobilePhone'=> ''
      ];
      
    }

    public function mapStudentSDToMother($studentSD){      
      return[
        'name'=> $studentSD->studentSiswaSD->namaIbu,
        //'birth_date'=> '1890-01-01',
        'sex_type_value'=> 2,
        'parent_type_value'=> 2,
        //'wali_type_value'=> null,
        'job'=> $studentSD->studentSiswaSD->pekerjaanIbu,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> ''
        //'ktp'=> '',
        //'nkk'=> '',
        //'email'=> '',
        //'mobilePhone'=> ''
      ];
    }

    public function syncStudentSMP($tahun_pelajaran_id){
      set_time_limit(0);
      $father_parent_id = null;
      $mother_parent_id = null;
      $this->jenjang = $this->jenjangRepository->getJenjangByCode('SMP')->first();
      $this->school = $this->schoolRepository->getSchoolByJenjang($this->jenjang->id)->first();
      if(isset($tahun_pelajaran_id)){        
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranById($tahun_pelajaran_id)->first();
      }else{
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      }      
      $roleStudent = $this->roleRepository->getRoleByCode('STUDENT')->first();
      $roleParent = $this->roleRepository->getRoleByCode('PARENT')->first();
      $existingStudents = $this->studentRepository->getAllStudents()->pluck('niy');
      
      $existingUsers = $this->userRepository->getAllUsers()->pluck('username')->all();      
      $studentSMPs = $this->studentRepository->getStudentSMPWithBukuInduk($this->tahunActive->name)->get();     
      
      //return $studentSMPs; 

      $test = [];
      /*
      foreach ($studentSMPs as $studentSMP) {
        $dataStudent = $this->mapStudentSMPToStudent($studentSMP);
        array_push($test,$dataStudent);
      }

      return $test;
      */

      
      foreach ($studentSMPs as $studentSMP) {
        $dataStudent = $this->mapStudentSMPToStudent($studentSMP);

        $emailAyah = null;
        $kkAyah = $studentSMP->siswaEdit->no_kk===""||$studentSMP->siswaEdit->no_kk==="0" ? null : $studentSMP->siswaEdit->no_kk;
        $ktpAyah = $studentSMP->siswaEdit->ktpAyah===""||$studentSMP->siswaEdit->ktpAyah==="0" ? null : $studentSMP->siswaEdit->ktpAyah;
        //$emailAyah = $studentSMP->studentSiswaSD->email===""? null : $studentSMP->studentSiswaSD->email;
        $mobilePhoneAyah = $studentSMP->siswaEdit->hpAyah===""||$studentSMP->siswaEdit->hpAyah==="0" ? null : $studentSMP->siswaEdit->hpAyah;
        
        $emailIbu = null;
        $kkIbu = $studentSMP->siswaEdit->no_kk===""||$studentSMP->siswaEdit->no_kk==="0" ? null : $studentSMP->siswaEdit->no_kk;
        $ktpIbu = $studentSMP->siswaEdit->ktpIbu===""||$studentSMP->siswaEdit->ktpIbu==="0" ? null : $studentSMP->siswaEdit->ktpIbu;
        //$emailIbu = $studentSMP->studentSiswaSD->email===""? null : $studentSMP->studentSiswaSD->email;
        $mobilePhoneIbu = $studentSMP->siswaEdit->hpIbu===""||$studentSMP->siswaEdit->hpIbu==="0" ? null : $studentSMP->siswaEdit->hpIbu;
    
        $existingFather=null;

        if($ktpAyah !== null ){
          $existingFather = $this->parentRepository->getExistingParentByKtp($ktpAyah,1)->first();
        }
        if($existingFather===null && $emailAyah !== null ){
          //$existingFather = $this->parentRepository->getExistingParentByEmail($emailAyah,1)->first();
        }
        if($existingFather===null && $mobilePhoneAyah !== null){
          //$existingFather = $this->parentRepository->getExistingParentByMobilePhone($mobilePhoneAyah,1)->first();
        }
        if($existingFather===null && $kkAyah !== null){
          $existingFather = $this->parentRepository->getExistingParentByKk($kkAyah,1)->first();
        }
              
        
        $existingMother=null;
        
        if($ktpIbu !== null ){
          $existingMother = $this->parentRepository->getExistingParentByKtp($ktpIbu,2)->first();
        }
        if($existingMother===null && $emailIbu !== null ){
          //$existingMother = $this->parentRepository->getExistingParentByEmail($emailIbu,2)->first();
        }
        if($existingMother===null && $mobilePhoneIbu !== null){
          //$existingMother = $this->parentRepository->getExistingParentByMobilePhone($mobilePhoneIbu,2)->first();
        }
        if($existingMother===null && $kkIbu !== null){
          $existingMother = $this->parentRepository->getExistingParentByKk($kkIbu,2)->first();
        }                        

        //array_push($test,$existingMother);
        //continue;
        //father
        if ($existingFather) {
          $father_parent_id = $existingFather->id;
          $dataStudent['is_sibling_student'] = 1;
        } else{
          if (!in_array('F'.$studentSMP->nis, $existingUsers)) {
            $user_father_id = $this->userRepository->insertUserGetId(
              [
                'name'=>$studentSMP->siswaEdit->nama_ayah,
                //'email'=>$emailAyah,
                'username'=>'F'.$studentSMP->nis,
                'password'=>bcrypt('F'.$studentSMP->nis),
                'user_type_value'=>3
              ]
            );
            $dataFather = $this->mapStudentSMPToFather($studentSMP);
            $dataFather['user_id'] = $user_father_id;          
            $dataFather['ktp']= $ktpAyah;
            $dataFather['nkk']=  $kkAyah;
            $dataFather['email']=$emailAyah;
            $dataFather['mobilePhone']= $mobilePhoneAyah;    
        
            $father_parent_id = $this->parentRepository->insertParentGetId($dataFather);  
            $this->roleRepository->syncUserRole($user_father_id, $roleParent->id);
            array_push($existingUsers,'F'.$studentSMP->nis);
          }
          
        }  
        
        
        //mother
        if ($existingMother) {
          $mother_parent_id = $existingMother->id;
          $dataStudent['is_sibling_student'] = 1;
        } else{
          if (!in_array('M'.$studentSMP->nis, $existingUsers)) {
            $user_mother_id = $this->userRepository->insertUserGetId(
              [
                'name'=>$studentSMP->siswaEdit->nama_ibu,
                //'email'=>$emailIbu,
                'username'=>'M'.$studentSMP->nis,
                'password'=>bcrypt('M'.$studentSMP->nis),
                'user_type_value'=>3
              ]
            );
  
            $dataMother = $this->mapStudentSMPToMother($studentSMP);
            $dataMother['user_id'] = $user_mother_id;  
            $dataMother['ktp']= $ktpIbu;
            $dataMother['nkk']=  $kkIbu;
            $dataMother['email']=$emailIbu;
            $dataMother['mobilePhone']= $mobilePhoneIbu;        
            
            $mother_parent_id = $this->parentRepository->insertParentGetId($dataMother);  
            $this->roleRepository->syncUserRole($user_mother_id, $roleParent->id);
            array_push($existingUsers,'M'.$studentSMP->nis);
          }
          
        }  

        //student
        if (!in_array($studentSMP->nis, $existingUsers)) {
          $user_student_id = $this->userRepository->insertUserGetId(
            [
              'name'=>$studentSMP->nama,
              //'email'=>$studentSMP->nis."@email.com",
              'username'=>$studentSMP->nis,
              'password'=>bcrypt($studentSMP->nis),
              'user_type_value'=>2
            ]
          );
          
          
          
          $dataStudent['user_id'] = $user_student_id;
          $dataStudent['father_ktp'] = $ktpAyah;
          $dataStudent['mother_ktp'] = $ktpIbu;          
          $dataStudent['father_parent_id'] = $father_parent_id;
          $dataStudent['mother_parent_id'] = $mother_parent_id;                             
          $dataStudent['jenjang_id'] = $this->jenjang->id;    
          $dataStudent['school_id'] = $this->school->id;     
          
          
          $this->studentRepository->insertStudent($dataStudent);  
          $this->roleRepository->syncUserRole($user_student_id, $roleStudent->id);
          array_push($existingUsers,$studentSMP->nis);
        }                         

                               
        
      }
      
      $this->saveStudentMutation();
     
      //return $students;
      return ['message'=>'success'];
            
    }

    public function mapStudentSMPToStudent($studentSMP){  
      
      $kelasName = $this->getKelasName($studentSMP->siswaKelas->kelasSMP->kelas);
      $kelas = $this->kelasRepository->getKelasByNameAndJenjangId($kelasName, $this->jenjang->id)->first();          
      $parallel = $this->parallelRepository->getParallelByNameAndKelasId($studentSMP->siswaKelas->kelasSMP->paralel, $kelas->id)->first();        
      $religion = $this->parameterRepository->getReligionParameters($studentSMP->siswaEdit->agama)->first();

      return[
        'kelas_id'=> $kelas !== null ? $kelas->id:null,
        'parallel_id'=> $parallel !== null ? $parallel->id:null,        
        //'masuk_tahun_id'	=> null,
        //'masuk_jenjang_id'	=> null,
        //'masuk_kelas_id'	=> null,
        //'is_father_alive'	=> 1,
        //'is_mother_alive'	=> 1,
        //'is_poor'	=> 0,
        'name'=> $studentSMP->nama,
        'nis'=> $studentSMP->siswaNisn->niy, //emang kebalik
        'niy'=> $studentSMP->nis,        
        'nisn'	=> $studentSMP->siswaNisn->nisn,
        //'nkk'=> $studentSMP->bukuInduk ? $studentSMP->bukuInduk->no_kartu_keluarga:null,
        //'father_ktp'	=> null,
        //'mother_ktp'	=> null,
        //'email'	=> null,
        'sex_type_value'	=> $studentSMP->siswaEdit->jenis_kelamin==='laki-laki' ?1:2,
        'address'	=> $studentSMP->siswaEdit->alamat,
        //'kota'	=> null,
        //'kecamatan'	=> null,
        //'kelurahan'	=> null,
        //'kodepos'	=> null,
        //'photo'	=> null,
        'handphone'	=> $studentSMP->siswaEdit->telp,
        'birth_place'	=> $studentSMP->siswaEdit->tmp_lahir,
        'birth_date'	=> $studentSMP->siswaEdit->tgl_lahir,
        'birth_order'	=> $studentSMP->siswaEdit->anak_ke,
        'religion_value'	=> $religion !== null ? $religion->value:null,
        'nationality'	=> $studentSMP->siswaNisn->warga_negara,
        //'language'	=> null,
        //'is_adopted'	=> 0,
        //'stay_with_value'	=> 1,
        //'siblings'	=> 0,
        'is_sibling_student'	=> 0,
        //'foster'	=> 0,
        //'step_siblings'	=> 0,
        //'medical_history'	=> null,
        'is_active'	=> $studentSMP->active,
        //'student_status_value'	=> 1,
        //'lulus_tahun_id'	=> null,
        //'tahun_lulus'	=> null,
        //'gol_darah'	=> null,
        //'is_cacat'	=> 0,
        //'tinggi'	=> 0,
        //'berat'	=> 0,
        'sekolah_asal'	=> $studentSMP->siswaEdit->sekolah_asal
      ];
    }
    
    public function mapStudentSMPToFather($studentSMP){      
      return[
        'name'=> $studentSMP->siswaEdit->nama_ayah,
        //'birth_date'=> '1890-01-01',
        'sex_type_value'=> 1,
        'parent_type_value'=> 1,
        //'wali_type_value'=> null,
        'job'=> $studentSMP->siswaEdit->pek_ayah,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> ''
        //'ktp'=> ''
        //'nkk'=> ''
        //'email'=> ''
        //'mobilePhone'=> ''
      ];
      
    }

    public function mapStudentSMPToMother($studentSMP){      
      return[
        'name'=> $studentSMP->siswaEdit->nama_ibu,
        //'birth_date'=> '1890-01-01',
        'sex_type_value'=> 2,
        'parent_type_value'=> 2,
        //'wali_type_value'=> null,
        'job'=> $studentSMP->siswaEdit->pek_ibu,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> ''
        //'ktp'=> ''
        //'nkk'=> ''
        //'email'=> ''
        //'mobilePhone'=> ''
      ];
    }
    
    public function syncStudentSMA($tahun_pelajaran_id){
      set_time_limit(0);
      $father_parent_id = null;
      $mother_parent_id = null;
      $this->jenjang = $this->jenjangRepository->getJenjangByCode('SMA')->first();
      $this->school = $this->schoolRepository->getSchoolByJenjang($this->jenjang->id)->first();
      if(isset($tahun_pelajaran_id)){        
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranById($tahun_pelajaran_id)->first();
      }else{
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      }      
      $roleStudent = $this->roleRepository->getRoleByCode('STUDENT')->first();
      $roleParent = $this->roleRepository->getRoleByCode('PARENT')->first();
      $existingStudents = $this->studentRepository->getAllStudents()->pluck('niy');
      
      $existingUsers = $this->userRepository->getAllUsers()->pluck('username')->all();      
      $studentSMAs = $this->studentRepository->getStudentSMAWithBukuInduk($this->tahunActive->name)->get();     
      
      //return $studentSMAs; 

      $test = [];
      /*
      foreach ($studentSMAs as $studentSMA) {
        $dataStudent = $this->mapStudentSMAToStudent($studentSMA);
        array_push($test,$dataStudent);
      }

      return $test;
      */
      

      
      foreach ($studentSMAs as $studentSMA) {
        $dataStudent = $this->mapStudentSMAToStudent($studentSMA);

        $kkAyah = null;
        $ktpAyah= null;
        //$kkAyah = $studentSMA->bukuInduk->no_kk===""||$studentSMA->bukuInduk->no_kk==="0" ? null : $studentSMA->bukuInduk->no_kk;
        //$ktpAyah = $studentSMA->bukuInduk->ktpAyah===""||$studentSMA->bukuInduk->ktpAyah==="0" ? null : $studentSMA->bukuInduk->ktpAyah;
        $emailAyah = $studentSMA->bukuInduk->emailayah===""? null : $studentSMA->bukuInduk->emailayah;
        $mobilePhoneAyah = $studentSMA->bukuInduk->hpayah===""||$studentSMA->bukuInduk->hpayah==="0" ? null : $studentSMA->bukuInduk->hpayah;
        
        $kkIbu = null;
        $ktpIbu = null;
        //$kkIbu = $studentSMA->bukuInduk->no_kk===""||$studentSMA->bukuInduk->no_kk==="0" ? null : $studentSMA->bukuInduk->no_kk;
        //$ktpIbu = $studentSMA->bukuInduk->ktpIbu===""||$studentSMA->bukuInduk->ktpIbu==="0" ? null : $studentSMA->bukuInduk->ktpIbu;
        $emailIbu = $studentSMA->bukuInduk->emailibu===""? null : $studentSMA->bukuInduk->emailibu;
        $mobilePhoneIbu = $studentSMA->bukuInduk->hpibu===""||$studentSMA->bukuInduk->hpibu==="0" ? null : $studentSMA->bukuInduk->hpibu;
    
        $existingFather=null;

        if($ktpAyah !== null ){
          $existingFather = $this->parentRepository->getExistingParentByKtp($ktpAyah,1)->first();
        }
        if($existingFather===null && $emailAyah !== null ){
          //$existingFather = $this->parentRepository->getExistingParentByEmail($emailAyah,1)->first();
        }
        if($existingFather===null && $mobilePhoneAyah !== null){
          //$existingFather = $this->parentRepository->getExistingParentByMobilePhone($mobilePhoneAyah,1)->first();
        }
        if($existingFather===null && $kkAyah !== null){
          $existingFather = $this->parentRepository->getExistingParentByKk($kkAyah,1)->first();
        }
              
        
        $existingMother=null;
        
        if($ktpIbu !== null ){
          $existingMother = $this->parentRepository->getExistingParentByKtp($ktpIbu,2)->first();
        }
        if($existingMother===null && $emailIbu !== null ){
          //$existingMother = $this->parentRepository->getExistingParentByEmail($emailIbu,2)->first();
        }
        if($existingMother===null && $mobilePhoneIbu !== null){
          //$existingMother = $this->parentRepository->getExistingParentByMobilePhone($mobilePhoneIbu,2)->first();
        }
        if($existingMother===null && $kkIbu !== null){
          $existingMother = $this->parentRepository->getExistingParentByKk($kkIbu,2)->first();
        }                        

        //array_push($test,$existingMother);
        //continue;
        //father
        if ($existingFather) {
          $father_parent_id = $existingFather->id;
          $dataStudent['is_sibling_student'] = 1;
        } else{
          if (!in_array('F'.$studentSMA->niy, $existingUsers)) {
            $user_father_id = $this->userRepository->insertUserGetId(
              [
                'name'=>$studentSMA->bukuInduk->namaayah,
                'email'=>$studentSMA->bukuInduk->emailayah,
                'username'=>'F'.$studentSMA->niy,
                'password'=>bcrypt('F'.$studentSMA->niy),
                'user_type_value'=>3
              ]
            );
            $dataFather = $this->mapStudentSMAToFather($studentSMA);
            $dataFather['user_id'] = $user_father_id; 
            $dataFather['ktp']= $ktpAyah;
            $dataFather['nkk']=  $kkAyah;
            $dataFather['email']=$emailAyah;
            $dataFather['mobilePhone']= $mobilePhoneAyah;         
            
            $father_parent_id = $this->parentRepository->insertParentGetId($dataFather);  
            $this->roleRepository->syncUserRole($user_father_id, $roleParent->id);
            array_push($existingUsers,'F'.$studentSMA->niy);
          }
          
        }  
        
        
        //mother
        if ($existingMother) {
          $mother_parent_id = $existingMother->id;
          $dataStudent['is_sibling_student'] = 1;
        } else{
          if (!in_array('M'.$studentSMA->niy, $existingUsers)) {
            $user_mother_id = $this->userRepository->insertUserGetId(
              [
                'name'=>$studentSMA->bukuInduk->namaibu,
                'email'=>$studentSMA->bukuInduk->emailibu,
                'username'=>'M'.$studentSMA->niy,
                'password'=>bcrypt('M'.$studentSMA->niy),
                'user_type_value'=>3
              ]
            );
  
            $dataMother = $this->mapStudentSMAToMother($studentSMA);
            $dataMother['user_id'] = $user_mother_id; 
            $dataMother['ktp']= $ktpIbu;
            $dataMother['nkk']=  $kkIbu;
            $dataMother['email']=$emailIbu;
            $dataMother['mobilePhone']= $mobilePhoneIbu;          
            
            $mother_parent_id = $this->parentRepository->insertParentGetId($dataMother);  
            $this->roleRepository->syncUserRole($user_mother_id, $roleParent->id);
            array_push($existingUsers,'M'.$studentSMA->niy);
          }
          
        }  

        //student
        if (!in_array($studentSMA->niy, $existingUsers)) {
          $user_student_id = $this->userRepository->insertUserGetId(
            [
              'name'=>$studentSMA->nama,
              'email'=>$studentSMA->bukuInduk->email,
              'username'=>$studentSMA->niy,
              'password'=>bcrypt($studentSMA->niy),
              'user_type_value'=>2
            ]
          );
          
                    
          $dataStudent['user_id'] = $user_student_id;
          $dataStudent['father_ktp'] = $ktpAyah;
          $dataStudent['mother_ktp'] = $ktpIbu;
          $dataStudent['father_parent_id'] = $father_parent_id;
          $dataStudent['mother_parent_id'] = $mother_parent_id;                             
          $dataStudent['jenjang_id'] = $this->jenjang->id;    
          $dataStudent['school_id'] = $this->school->id;     
          
          
          $this->studentRepository->insertStudent($dataStudent);  
          $this->roleRepository->syncUserRole($user_student_id, $roleStudent->id);
          array_push($existingUsers,$studentSMA->niy);
        }                                                        
        
      }
      
      $this->saveStudentMutation();

      //return $students;
      return ['message'=>'success'];
            
    }

    public function mapStudentSMAToStudent($studentSMA){  
      
      $kelasName = $this->getKelasName($studentSMA->kelasSMA->kelas);
      $kelas = $this->kelasRepository->getKelasByNameAndJenjangId($kelasName, $this->jenjang->id)->first();          
      $parallel = $this->parallelRepository->getParallelByNameAndKelasId($studentSMA->kelasSMA->pararel, $kelas->id)->first();        
      $religion = $this->parameterRepository->getReligionParameters($studentSMA->bukuInduk->agama)->first();

      return[
        'kelas_id'=> $kelas !== null ? $kelas->id:null,
        'parallel_id'=> $parallel !== null ? $parallel->id:null,        
        //'masuk_tahun_id'	=> null,
        //'masuk_jenjang_id'	=> null,
        //'masuk_kelas_id'	=> null,
        //'is_father_alive'	=> 1,
        //'is_mother_alive'	=> 1,
        //'is_poor'	=> 0,
        'name'=> $studentSMA->nama,
        'nis'=> $studentSMA->nis,
        'niy'=> $studentSMA->niy,        
        'nisn'	=> $studentSMA->nin,
        //'nkk'=> $studentSMA->bukuInduk ? $studentSMA->bukuInduk->no_kartu_keluarga:null,
        //'father_ktp'	=> null,
        //'mother_ktp'	=> null,
        'email'	=> $studentSMA->bukuInduk->email,
        'sex_type_value'	=> $studentSMA->bukuInduk->jk==='l' ?1:2,
        'address'	=> $studentSMA->bukuInduk->alamat,
        //'kota'	=> null,
        //'kecamatan'	=> null,
        //'kelurahan'	=> null,
        //'kodepos'	=> null,
        //'photo'	=> null,
        'handphone'	=> $studentSMA->bukuInduk->hp,
        'birth_place'	=> $studentSMA->bukuInduk->tlahir,
        'birth_date'	=> $studentSMA->bukuInduk->thnLahir."-".$this->getIndonesianMonthNumber($studentSMA->bukuInduk->blnLahir)."-".$studentSMA->bukuInduk->tglLahir,
        'birth_order'	=> $studentSMA->bukuInduk->anakKe,
        'religion_value'	=> $religion !== null ? $religion->value:null,
        'nationality'	=> $studentSMA->bukuInduk->warga,
        //'language'	=> null,
        //'is_adopted'	=> 0,
        //'stay_with_value'	=> 1,
        //'siblings'	=> 0,
        'is_sibling_student'	=> 0,
        //'foster'	=> 0,
        //'step_siblings'	=> 0,
        //'medical_history'	=> null,
        //'is_active'	=> $studentSMA->active,
        //'student_status_value'	=> 1,
        //'lulus_tahun_id'	=> null,
        //'tahun_lulus'	=> null,
        //'gol_darah'	=> null,
        //'is_cacat'	=> 0,
        //'tinggi'	=> 0,
        //'berat'	=> 0,
        'sekolah_asal'	=> $studentSMA->bukuInduk->sekolahAsal
      ];
    }
    
    public function mapStudentSMAToFather($studentSMA){      
      return[
        'name'=> $studentSMA->bukuInduk->namaayah,
        //'birth_date'=> '1890-01-01',
        'sex_type_value'=> 1,
        'parent_type_value'=> 1,
        //'wali_type_value'=> null,
        'job'=> $studentSMA->bukuInduk->pekerjaanayah,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> ''
                //'ktp'=> ''
        //'nkk'=> ''
        //'email'=> ''
        //'mobilePhone'=> ''
      ];
      
    }

    public function mapStudentSMAToMother($studentSMA){      
      return[
        'name'=> $studentSMA->bukuInduk->namaibu,
        //'birth_date'=> '1890-01-01',
        'sex_type_value'=> 1,
        'parent_type_value'=> 1,
        //'wali_type_value'=> null,
        'job'=> $studentSMA->bukuInduk->pekerjaanibu,
        //'jobCorporateName'=> '',
        //'jobPositionName'=> '',
        //'jobWorkAddress'=> ''
                //'ktp'=> ''
        //'nkk'=> ''
        //'email'=> ''
        //'mobilePhone'=> ''
      ];
    }

    public function syncStudentPCI($tahun_pelajaran_id){
      if(isset($tahun_pelajaran_id)){        
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranById($tahun_pelajaran_id)->first();
      }else{
        $this->tahunActive = $this->tahunPelajaranRepository->getTahunPelajaranActive()->first();
      }      
      
      return $this->studentRepository->getStudentPCI($this->tahunActive->name)->get();
    }

    public function deleteStudents($ids){
      $this->studentRepository->deleteStudents($ids);          
    }

    function getIndonesianMonthNumber($monthName){
      if($monthName==='Januari'){
        return '01';
      }
      elseif($monthName==='Februari'){
        return '02';
      }
      elseif($monthName==='Maret'){
        return '03';
      }
      elseif($monthName==='April'){
        return '04';
      }
      elseif($monthName==='Mei'){
        return '05';
      }
      elseif($monthName==='Juni'){
        return '06';
      }
      elseif($monthName==='Juli'){
        return '07';
      }
      elseif($monthName==='Agustus'){
        return '08';
      }
      elseif($monthName==='September'){
        return '09';
      }
      elseif($monthName==='Oktober'){
        return '10';
      }
      elseif($monthName==='November'){
        return '11';
      }
      elseif($monthName==='Desember'){
        return '12';
      }

    }
    
    function getKelasName($kelasName){
      if($kelasName==='I'){
        return '1';
      }
      elseif($kelasName==='II'){
        return '2';
      }
      elseif($kelasName==='III'){
        return '3';
      }
      elseif($kelasName==='IV'){
        return '4';
      }
      elseif($kelasName==='V'){
        return '5';
      }
      elseif($kelasName==='VI'){
        return '6';
      }
      elseif($kelasName==='VII'){
        return '7';
      }
      elseif($kelasName==='VIII'){
        return '8';
      }
      elseif($kelasName==='IX'){
        return '9';
      }
      elseif($kelasName==='X'){
        return '10';
      }
      elseif($kelasName==='XI'){
        return '11';
      }
      elseif($kelasName==='XII'){
        return '12';
      }
      else{
        return $kelasName;
      }
    }
 
        
}
