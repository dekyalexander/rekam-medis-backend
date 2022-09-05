<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentController extends Controller{
  protected $studentService;

  public function __construct(StudentService $studentService){
    $this->studentService = $studentService;
  }

  public function getStudentsByFilters(Request $request)
  {
    $filters=[
      'keyword'=>$request->keyword,
      'parent_id'=>$request->parent_id,
      'student_id'=>$request->student_id,
      'school_id'=>$request->school_id,
      'kelas_id'=>$request->kelas_id,
      'parallel_id'=>$request->parallel_id,
      'is_sibling'=>$request->is_sibling
    ];
    return $this->studentService->getByFiltersPagination($filters, $request->rowsPerPage);
  }

  public function getStudentOptions(Request $request){
    $filters=[
      'roles_id' => $request->roles_id,
      'user_id' => $request->user_id,
      'name'=>$request->name
    ];
    return $this->studentService->getStudentOptions($filters);
  }

  public function getStudentDetail($student_id){
    return $this->studentService->getStudentDetail($student_id);
  }

  public function getParentsOfStudent(Request $request){    
    return $this->studentService->getParentsOfStudent($request->student_id);
  }

  public function getMutationsOfStudent(Request $request){    
    return $this->studentService->getMutationsOfStudent($request->niy);
  }

  public function getSiblingsOfStudent(Request $request){    
    return $this->studentService->getSiblingsOfStudent($request->niy);
  }

  public function createStudent(Request $request){
    try{
      $data = [
        'user_id'	=> $request->user_id,
        'father_parent_id'	=> $request->father_parent_id,
        'mother_parent_id'	=> $request->mother_parent_id,
        'father_employee_id'	=> $request->father_employee_id,
        'mother_employee_id'	=> $request->mother_employee_id,
        'wali_parent_id'	=> $request->wali_parent_id,
        'wali_employee_id'	=> $request->wali_employee_id,
        'jenjang_id'	=> $request->jenjang_id,
        'school_id'	=> $request->school_id,
        'kelas_id'	=> $request->kelas_id,
        'parallel_id'	=> $request->parallel_id,
        'masuk_tahun_id'	=> $request->masuk_tahun_id,
        'masuk_jenjang_id'	=> $request->masuk_jenjang_id,
        'masuk_kelas_id'	=> $request->masuk_kelas_id,
        'is_father_alive'	=> $request->is_father_alive,
        'is_mother_alive'	=> $request->is_mother_alive,
        'is_poor'	=> $request->is_poor,
        'nis'	=> $request->nis,
        'niy'	=> $request->niy,
        'nisn'	=> $request->nisn,
        'nkk'	=> $request->nkk,
        'father_ktp'	=> $request->father_ktp,
        'mother_ktp'	=> $request->mother_ktp,
        'name'	=> $request->name,
        'email'	=> $request->email,
        'sex_type_value'	=> $request->sex_type_value,
        'address'	=> $request->address,
        'kota'	=> $request->kota,
        'kecamatan'	=> $request->kecamatan,
        'kelurahan'	=> $request->kelurahan,
        'kodepos'	=> $request->kodepos,
        'photo'	=> $request->photo,
        'handphone'	=> $request->handphone,
        'birth_place'	=> $request->birth_place,
        'birth_date'	=> $request->birth_date,
        'birth_order'	=> $request->birth_order,
        'religion_value'	=> $request->religion_value,
        'nationality'	=> $request->nationality,
        'language'	=> $request->language,
        'is_adopted'	=> $request->is_adopted,
        'stay_with_value'	=> $request->stay_with_value,
        'siblings'	=> $request->siblings,
        'is_sibling_student'	=> $request->is_sibling_student,
        'foster'	=> $request->foster,
        'step_siblings'	=> $request->step_siblings,
        'medical_history'	=> $request->medical_history,
        'is_active'	=> $request->is_active,
        'student_status_value'	=> $request->student_status_value,
        'lulus_tahun_id'	=> $request->lulus_tahun_id,
        'tahun_lulus'	=> $request->tahun_lulus,
        'gol_darah'	=> $request->gol_darah,
        'is_cacat'	=> $request->is_cacat,
        'tinggi'	=> $request->tinggi,
        'berat'	=> $request->berat,
        'sekolah_asal'	=> $request->sekolah_asal,
        'created_at'=>  Carbon::now()
      ];
      $this->studentService->createStudent($data);      
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed create student']);
    }

  }

  public function updateStudent(Request $request){
    try{
      $data = [
      'user_id'	=> $request->user_id,
      'father_parent_id'	=> $request->father_parent_id,
      'mother_parent_id'	=> $request->mother_parent_id,
      'father_employee_id'	=> $request->father_employee_id,
      'mother_employee_id'	=> $request->mother_employee_id,
      'wali_parent_id'	=> $request->wali_parent_id,
      'wali_employee_id'	=> $request->wali_employee_id,
      'jenjang_id'	=> $request->jenjang_id,
      'school_id'	=> $request->school_id,
      'kelas_id'	=> $request->kelas_id,
      'parallel_id'	=> $request->parallel_id,
      'masuk_tahun_id'	=> $request->masuk_tahun_id,
      'masuk_jenjang_id'	=> $request->masuk_jenjang_id,
      'masuk_kelas_id'	=> $request->masuk_kelas_id,
      'is_father_alive'	=> $request->is_father_alive,
      'is_mother_alive'	=> $request->is_mother_alive,
      'is_poor'	=> $request->is_poor,
      'nis'	=> $request->nis,
      'niy'	=> $request->niy,
      'nisn'	=> $request->nisn,
      'nkk'	=> $request->nkk,
      'father_ktp'	=> $request->father_ktp,
      'mother_ktp'	=> $request->mother_ktp,
      'name'	=> $request->name,
      'email'	=> $request->email,
      'sex_type_value'	=> $request->sex_type_value,
      'address'	=> $request->address,
      'kota'	=> $request->kota,
      'kecamatan'	=> $request->kecamatan,
      'kelurahan'	=> $request->kelurahan,
      'kodepos'	=> $request->kodepos,
      'photo'	=> $request->photo,
      'handphone'	=> $request->handphone,
      'birth_place'	=> $request->birth_place,
      'birth_date'	=> $request->birth_date,
      'birth_order'	=> $request->birth_order,
      'religion_value'	=> $request->religion_value,
      'nationality'	=> $request->nationality,
      'language'	=> $request->language,
      'is_adopted'	=> $request->is_adopted,
      'stay_with_value'	=> $request->stay_with_value,
      'siblings'	=> $request->siblings,
      'is_sibling_student'	=> $request->is_sibling_student,
      'foster'	=> $request->foster,
      'step_siblings'	=> $request->step_siblings,
      'medical_history'	=> $request->medical_history,
      'is_active'	=> $request->is_active,
      'student_status_value'	=> $request->student_status_value,
      'lulus_tahun_id'	=> $request->lulus_tahun_id,
      'tahun_lulus'	=> $request->tahun_lulus,
      'gol_darah'	=> $request->gol_darah,
      'is_cacat'	=> $request->is_cacat,
      'tinggi'	=> $request->tinggi,
      'berat'	=> $request->berat,
      'sekolah_asal'	=> $request->sekolah_asal,
      'updated_at'=>  Carbon::now()
      ];
      $this->studentService->updateStudent($data, $request->id);      

      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed update student']);
    }
  }

  public function syncStudent(Request $request){
    if(isset($request->jenjang_code)){
      if($request->jenjang_code==='TK'){
        return $this->studentService->syncStudentTK($request->tahun_pelajaran_id);      
      }elseif ($request->jenjang_code==='SD') {
        return $this->studentService->syncStudentSD($request->tahun_pelajaran_id);
      }elseif ($request->jenjang_code==='SMP') {
        return $this->studentService->syncStudentSMP($request->tahun_pelajaran_id);
      }elseif ($request->jenjang_code==='SMA') {
        return $this->studentService->syncStudentSMA($request->tahun_pelajaran_id);
      }elseif ($request->jenjang_code==='PCI') {
        return $this->studentService->syncStudentPCI($request->tahun_pelajaran_id);
      }
    }
    return response(['error' => 'no jenjang_code', 'message' => 'please input jenjang code']);
  }

  public function deleteStudents(Request $request){
    try{      
      $this->studentService->deleteStudents($request->ids);
      return response(['message'=>'success']);

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed delete student']);
    }
  }

  
}
