<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\EmployeeContacts;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use Carbon\Carbon;

class EmailController extends Controller
{

  protected $EmailService;

  public function __construct(EmailService $EmailService){
    $this->EmailService = $EmailService;
  }
  
  // public function index(){

  //   $email_content = [
  //       'title' => 'Undangan Pengisian Riwayat Kesehatan Siswa Dan Karyawan Sekolah Terpadu Pahoa',
  //       'body' => 'http://sispahoa.sch.id/medical-record/',
  //   ];

  //   $destination_email = 'dekyalexander200@gmail.com';

  //   Mail::to($destination_email)->send(new Email($email_content));
    
  //   return 'Berhasil Mengirim Email';
  // }

  // public function sendEmail(){

  //   try{

  //   $email_content = [
  //       'title' => 'Undangan Pengisian Riwayat Kesehatan Siswa Dan Karyawan Sekolah Terpadu Pahoa',
  //       'body' => 'Buka Tautan Link Untuk Mengisi Form : http://sispahoa.sch.id/screening/',
  //   ];

  //   $destination_email = 'dekyalexander200@gmail.com';

  //   Mail::to($destination_email)->send(new Email($email_content));
    
  //   return response(['message'=>'success']);

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed send email']);
  //   }
  // }

  //   public function index(){

  //   $destination_email = DB::table('emails')->pluck('email');
    
  //   return $destination_email;
  // }

  public function getstudentEmailOptions(Request $request){
    $filters=[
      'jenjang_id' => $request->jenjang_id
    ];
    return $this->EmailService->getstudentEmailOptions($filters);
  }

  public function getemployeeEmailOptions(Request $request){
    $filters=[
      'id' => $request->id
    ];
    return $this->EmailService->getemployeeEmailOptions($filters);
  }

  // public function getDataEmail(){

  //   try{

  //   // $email = EmployeeContacts::pluck('email')
  //   //      ->all();

  //   // $email = Student::pluck('email')
  //   //      ->all();

  //   $email = Student::select('name','email','jenjang_id')
  //   ->with(['jenjang:id,name,code'])
  //   ->whereHas('jenjang',function( $email){
  //                   return  $email->where('jenjang_id','4');
  //               })
  //        ->get();
    
  //   return $email;

  //   }catch(\Exception $e){
  //     return response(['error'=>$e->getMessage(), 'message'=>'failed get data email']);
  //   }
  // }

  public function sendEmailStudent(Request $request){

    try{

    $email_content = [
        'title' => $request->title,
        'body' => $request->body,
    ];

    // Daftar Email Percobaan

    // $destination_email = DB::table('emails')->pluck('email'); 


    $destination_email =  $this->getstudentEmailOptions($request);

    // Daftar Email Guru & Karyawan
    
    // $destination_email = EmployeeContacts::pluck('email')->all();

    // Daftar Email Siswa
    
    // $destination_email = Student::pluck('email')->all();


    Mail::to($destination_email)->send(new Email($email_content));
    
    return response(['message'=>'success']);

    // return $destination_email;

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed send email']);
    }
  }


  public function sendEmailEmployee(Request $request){

    try{

    $email_content = [
        'title' => $request->title,
        'body' => $request->body,
    ];


    $destination_email =  $this->getemployeeEmailOptions($request);


    Mail::to($destination_email)->send(new Email($email_content));
    
    return response(['message'=>'success']);

    // return $destination_email;

    }catch(\Exception $e){
      return response(['error'=>$e->getMessage(), 'message'=>'failed send email']);
    }
  }


}
