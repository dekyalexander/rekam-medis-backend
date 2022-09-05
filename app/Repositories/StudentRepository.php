<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\StudentTK;
use App\Models\StudentSD;
use App\Models\StudentSMP;
use App\Models\StudentKelasSMP;
use App\Models\StudentSMA;
use App\Models\StudentPCI;
use App\Models\StudentKelasSD;
use App\Models\StudentMutation;
use App\Models\TahunPelajaran;
use Carbon\Carbon;

class StudentRepository{
  protected $student;

  public function __construct(Student $student){
    $this->student = $student;
  }

  public function getStudentById($id,$selects=['*']){
    return Student::select($selects)
    ->where('id','=',$id);
  }

  public function getStudentByNIY($niy){
    return Student::where('niy',$niy);
  }

  public function getStudentDetail($student_id){
    return Student::
      with([
        'sex_type:parameters.value,parameters.name',
        'religion:parameters.value,parameters.name',
        'stay_with:parameters.value,parameters.name',
        'student_status:parameters.value,parameters.name',
        'jenjang:jenjangs.id,jenjangs.name',
        'masuk_jenjang:jenjangs.id,jenjangs.name',
        'school:schools.id,schools.name',
        'kelas:kelases.id,kelases.name',
        'masuk_kelas:kelases.id,kelases.name',
        'parallel:parallels.id,parallels.name',
        'masuk_tahun:tahun_pelajarans.id,tahun_pelajarans.name',
        'lulus_tahun:tahun_pelajarans.id,tahun_pelajarans.name',
      ])
      ->where('id','=',$student_id);
  }

  public function getStudentInIds($student_ids){
    return Student::whereIn('id',$student_ids);
  }

  public function getStudentsByParentId($parent_id){
    
    return Student::where('father_parent_id','=',$parent_id)
      ->orWhere('mother_parent_id','=',$parent_id);
  }

  public function getStudentsByFilters($filters)
  {
    return  
    Student::with([
      'user',
      'jenjang',
      'kelas',
      'parallel',
      'parent_mother:parents.id,parents.name,parents.ktp,parents.mobilePhone',
      'parent_father:parents.id,parents.name,parents.ktp,parents.mobilePhone',      
      'sex_type:parameters.value,parameters.name',
      'masuk_tahun:tahun_pelajarans.id,tahun_pelajarans.name',
      'student_status:parameters.value,parameters.name'      
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query
      ->orWhere('name','like','%'.$filters['keyword'].'%')
      ->orWhere('nis','like','%'.$filters['keyword'].'%')
      ->orWhere('niy','like','%'.$filters['keyword'].'%')
      ->orWhere('nkk','like','%'.$filters['keyword'].'%')
      ->orWhere('father_ktp','like','%'.$filters['keyword'].'%')
      ->orWhere('mother_ktp','like','%'.$filters['keyword'].'%')
      ;
    })
    ->when(isset($filters['is_sibling']), function ($query) use ($filters) {
        return $query->where('is_sibling_student',1)
                ->with([
                  'siblings_from_father:students.id,students.father_parent_id,students.mother_parent_id,students.nkk,students.name,students.niy,students.jenjang_id,students.kelas_id,students.parallel_id',
                  'siblings_from_mother:students.id,students.father_parent_id,students.mother_parent_id,students.nkk,students.name,students.niy,students.jenjang_id,students.kelas_id,students.parallel_id',
                  'siblings_from_kk:students.id,students.father_parent_id,students.mother_parent_id,students.nkk,students.name,students.niy,students.jenjang_id,students.kelas_id,students.parallel_id',
                  'siblings_from_father.jenjang',
                  'siblings_from_father.kelas',
                  'siblings_from_father.parallel',
                  'siblings_from_mother.jenjang',
                  'siblings_from_mother.kelas',
                  'siblings_from_mother.parallel',
                  'siblings_from_kk.jenjang',
                  'siblings_from_kk.kelas',
                  'siblings_from_kk.parallel'
                ]);
    })
    ->when(isset($filters['school_id']), function ($query) use ($filters) {
      return $query->where('school_id',$filters['school_id']);
    })
    ->when(isset($filters['kelas_id']), function ($query) use ($filters) {
      return $query->where('kelas_id',$filters['kelas_id']);
    })
    ->when(isset($filters['parallel_id']), function ($query) use ($filters) {
      return $query->where('parallel_id',$filters['parallel_id']);
    })
    ->when(isset($filters['parent_id']), function ($query) use ($filters) {      
      return $query->where('father_parent_id',$filters['parent_id'])  
      ->orWhere('mother_parent_id',$filters['parent_id']);
    })
    ->when(isset($filters['student_id']), function ($query) use ($filters) {      
      return $query->where('id',$filters['student_id']);
    });
  }

  public function getStudentOptions($filters){
    $student = Student::where('user_id', $filters['user_id'])->first();
    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }

    $tahun_pelajaran_id = TahunPelajaran::orderBy('id','desc')->limit(1)->pluck('id')->all();

    return Student::select('id','niy','name','address','kodepos','birth_date','jenjang_id','kelas_id','sex_type_value')
    
    ->with(['jenjang'=>function($query){
      $query->select('id', 'name','code');
    }])

    ->with(['kelas'=>function($query){
      $query->select('id', 'jenjang_id',
        'school_id',
        'name');
    }])

    ->with(['studentmutation'=>function($query) use($tahun_pelajaran_id){
      $query->where('tahun_pelajaran_id','=',$tahun_pelajaran_id)->with('tahunpelajaran', function ($q){
        return $q->select('id', 'name','is_active')->where('is_active','=',1);
      });
    }])


    ->with(['parents'=>function($query){
      $query->select('id', 'mobilePhone');
    }])

    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($student) {
      return $query->where('niy','=', $student->niy);
    })

    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  public function getStudentHasSibling(){
    return Student::where('is_sibling_student','=',1);
  }

  public function getStudentMutationNiyYear($niy, $tahun_pelajaran_id){
    return StudentMutation::where('niy',$niy)
            ->where('tahun_pelajaran_id',$tahun_pelajaran_id);
  }

  public function getSiblingByParentsId($niy, $father_parent_id, $mother_parent_id){
    return Student::with([
      'jenjang',
      'kelas',
      'parallel',
      'student_status:parameters.value,parameters.name'      
      ])
      ->where('niy','<>',$niy)
      ->where(function($query) use($father_parent_id,$mother_parent_id) {
        $query
        ->where('father_parent_id','=',$father_parent_id)
        ->orWhere('mother_parent_id','=',$mother_parent_id);
      })
      ;
  }

  public function getAllStudents(){
    return $this->student;
  }

  public function getStudentsByJenjang($jenjang_id){
    return Student::where('jenjang_id',$jenjang_id);
  }

  public function getStudentWithBukuIndukTK($tahun){
    return StudentTK::
    with(['bukuInduk'])
    ->select('id','nis','nama','kelas','level','jenjang','tahun_ajaran')
    ->where('tahun_ajaran',$tahun)
    ->has('bukuInduk');
  }

  public function getStudentSDWithBukuInduk($tahun){
    return StudentSD::
    with(['studentSiswaSD','coverRapotSD'])
    ->where('tahunAjaran',$tahun)
    ->has('studentSiswaSD')
    ->has('coverRapotSD');
  }

  public function getStudentSMPWithBukuInduk($tahun){
    return StudentSMP::
    with([
      'siswaEdit',
      'siswaNisn',
      'siswaKelas',
      'siswaKelas.kelasSMP'
      ])
    ->has('siswaEdit')
    ->has('siswaNisn')
    ->has('siswaKelas')
    ;
  }

  public function getStudentSMAWithBukuInduk($tahun){
    return StudentSMA::
    with([
      'bukuInduk',
      'kelasSMA'
      ])
    ->where('tahunajaran',$tahun)
    ->has('bukuInduk')
    ->has('kelasSMA')
    ;
  }

  public function getStudentKelasSD($tahun){
    return StudentKelasSD::where('tahunajaran',$tahun);
  }

  public function getStudentSD($tahun){
    return StudentSD::select('id','nis','nama','kelas_id','kelas','tahunajaran')
    ->where('tahunajaran',$tahun);
  }

  public function getStudentSMP($tahun){
    return StudentSMP::select('id','nama');
  }

  public function getStudentSMA($tahun){
    return StudentSMA::select('id','nis','niy','nin','nama','jenjang','kelas','tahunajaran')
    ->where('tahunajaran',$tahun);
  }

  public function getStudentPCI($tahun){
    return StudentPCI::select('id','nis','nama','kelas','jenjang','tahun_ajaran')
    ->where('tahun_ajaran',$tahun);
  }

  public function getMutationsOfStudent($niy){
    return StudentMutation::with([
      'jenjang',
      'school',
      'kelas',
      'parallel',
      'student_status:parameters.value,parameters.name',
      'tahunPelajaran'      
      ])
    ->where('niy',$niy);
  }

  
  public function insertStudent($data){
    Student::insert($data);
  }

  public function insertStudentMutation($data){
    StudentMutation::insert($data);
  }

  public function insertStudentGetId($data){
    return Student::insertGetId($data);
  }

  public function insertGetStudent($data){
    return Student::create($data);
  }

  public function updateStudent($data,$id){
    Student::where('id', $id)
            ->update($data);
  }

  public function updateStudentMutation($data,$id){
    StudentMutation::where('id', $id)
            ->update($data);
  }

  public function updateStudentByNIY($data,$niy){
    Student::where('niy', $niy)
            ->update($data);
  }

  public function updateStudentByNIS($data,$nis){
    Student::where('nis', $nis)
            ->update($data);
  }
  
  public function deleteStudents($ids){
    Student::whereIn('id', $ids)
            ->delete();
  }
}
