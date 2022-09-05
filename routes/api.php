<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//auth token
Route::get('/auth', 'AuthController@auth')->name('auth');
Route::post('/login', 'AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {

  //actions
  Route::get('/action', 'ActionController@data');
  Route::get('/action/option', 'ActionController@getForOptions');
  Route::get('/action/role', 'ActionController@getForRoles');
  Route::put('/action/approver', 'ActionController@addApprover');
  Route::get('/action/approver', 'ActionController@getApproverOfAction');
  Route::post('/action', 'ActionController@store');
  Route::get('/action/{id}', 'ActionController@edit');
  Route::put('/action', 'ActionController@update');
  Route::delete('/action', 'ActionController@destroy');
  Route::delete('/action/approver', 'ActionController@deleteApprover');

  //applications
  Route::get('/application', 'ApplicationController@data');
  Route::get('/application/option', 'ApplicationController@getForOptions');
  Route::get('/application/menu', 'ApplicationController@getMenusOfApplication');
  Route::post('/application', 'ApplicationController@store');
  Route::get('/application/{id}', 'ApplicationController@edit');
  Route::put('/application', 'ApplicationController@update');
  Route::put('/application/menu', 'ApplicationController@addMenuOfApplication'); 
  Route::delete('/application/menu', 'ApplicationController@deleteMenuOfApplication'); 
  Route::delete('/application', 'ApplicationController@destroy');

  //notification
  Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'getData']);
  Route::get('/notification/total-unread', [App\Http\Controllers\NotificationController::class, 'getTotalUnRead']);
  Route::put('/notification/update', [App\Http\Controllers\NotificationController::class, 'update']);

  // application categories
  Route::get('/application-categories', 'ApplicationCategoriesController@getApplicationCategories');
  Route::post('/application-categories', 'ApplicationCategoriesController@insertAplicationCategories');
  Route::delete('/application-categories', 'ApplicationCategoriesController@deleteApplicationCategories');

  // category Aplikasi
  Route::get('/category', 'CategoryApplicationController@getCategory');
  Route::post('/category', 'CategoryApplicationController@insertCategory');
  Route::delete('/category', 'CategoryApplicationController@deleteCategory');
  Route::put('/category', 'CategoryApplicationController@updateCategory');

  //approvals
  Route::get('/approval', 'ApprovalController@data');
  Route::post('/approval', 'ApprovalController@store');
  Route::get('/approval/{id}', 'ApprovalController@edit');
  Route::put('/approval', 'ApprovalController@update');
  Route::delete('/approval', 'ApprovalController@destroy');

  Route::get('/employee', 'EmployeeController@getEmployeesByFilters');
  Route::get('/employee/option', 'EmployeeController@getEmployeeOptions');
  Route::post('/employee', 'EmployeeController@createEmployee');
  Route::put('/employee', 'EmployeeController@updateEmployee');
  Route::delete('/employee', 'EmployeeController@deleteEmployees');  

  Route::get('/jenjang', 'JenjangController@getJenjangsByFilters');
  Route::get('/jenjang/option', 'JenjangController@getJenjangOptions');
  Route::post('/jenjang', 'JenjangController@createJenjang');
  Route::put('/jenjang', 'JenjangController@updateJenjang');
  Route::delete('/jenjang', 'JenjangController@deleteJenjangs'); 

  Route::get('/jurusan', 'JurusanController@getJurusansByFilters');
  Route::get('/jurusan/option', 'JurusanController@getJurusanOptions');
  Route::post('/jurusan', 'JurusanController@createJurusan');
  Route::put('/jurusan', 'JurusanController@updateJurusan');
  Route::delete('/jurusan', 'JurusanController@deleteJurusans');  
  Route::post('/jurusan/sync', 'JurusanController@syncJurusan');

  Route::get('/kelas', 'KelasController@getKelassByFilters');
  Route::get('/kelas/option', 'KelasController@getKelasOptions');
  Route::post('/kelas', 'KelasController@createKelas');
  Route::put('/kelas', 'KelasController@updateKelas');
  Route::delete('/kelas', 'KelasController@deleteKelass');  
  Route::post('/kelas/sync', 'KelasController@syncKelas');

  //menus
  Route::get('/menu', 'MenuController@data');
  Route::get('/menu/option', 'MenuController@getForOptions');
  Route::get('/menu/role', 'MenuController@getRoleOfMenu');
  Route::get('/menu/action', 'MenuController@getActionOfMenu');
  Route::post('/menu', 'MenuController@store');
  Route::get('/menu/{id}', 'MenuController@edit');
  Route::put('/menu', 'MenuController@update');
  Route::delete('/menu', 'MenuController@destroy');
  Route::delete('/menu/action', 'MenuController@deleteActionOfMenu'); 

  
  //parameters
  Route::get('/parameter', 'ParameterController@data');
  Route::get('/parameter/option', 'ParameterController@getForOptions');
  Route::post('/parameter', 'ParameterController@store');
  Route::get('/parameter/{id}', 'ParameterController@detail');
  Route::put('/parameter', 'ParameterController@update');
  Route::delete('/parameter', 'ParameterController@destroy');

  Route::get('/parallel', 'ParallelController@getParallelsByFilters');
  Route::get('/parallel/option', 'ParallelController@getParallelOptions');
  Route::post('/parallel', 'ParallelController@createParallel');
  Route::put('/parallel', 'ParallelController@updateParallel');
  Route::delete('/parallel', 'ParallelController@deleteParallels'); 
  Route::post('/parallel/sync', 'ParallelController@syncParallel');
  
  Route::get('/parent', 'ParentController@getParentsByFilters');
  Route::get('/parent/option', 'ParentController@getParentOptions');
  Route::post('/parent', 'ParentController@createParent');
  Route::put('/parent', 'ParentController@updateParent');
  Route::delete('/parent', 'ParentController@deleteParents');
  Route::get('/parent/student', 'ParentController@getStudentsOfParent');
  Route::get('/parent/{parent_id}', 'ParentController@getParentDetail');
  Route::put('/parent/student', 'ParentController@addStudentsToParent');

  //roles
  Route::get('/role', 'RoleController@data');
  Route::get('/role/user', 'RoleController@getUsersOfRole');
  Route::get('/role/option', 'RoleController@getForOptions');
  Route::get('/role/approval', 'RoleController@getApprovalsOfRole'); 
  Route::put('/role/approval', 'RoleController@addApproval'); 
  Route::put('/role/priviledge', 'RoleController@storePriviledge'); 
  Route::put('/role/user', 'RoleController@addUserOfRole');
  Route::post('/role', 'RoleController@store');
  Route::get('/role/{id}', 'RoleController@detail');
  Route::put('/role', 'RoleController@update');
  Route::delete('/role', 'RoleController@destroy');
  Route::delete('/role/user', 'RoleController@deleteUserOfRole');
  Route::delete('/role/approval', 'RoleController@deleteApprovalOfRole'); 


  Route::get('/student', 'StudentController@getStudentsByFilters');
  Route::get('/student/option', 'StudentController@getStudentOptions');  
  Route::post('/student', 'StudentController@createStudent');
  Route::put('/student', 'StudentController@updateStudent');
  Route::delete('/student', 'StudentController@deleteStudents');
  Route::get('/student/parent', 'StudentController@getParentsOfStudent');
  Route::post('/student/sync', 'StudentController@syncStudent');
  Route::get('/student/mutation', 'StudentController@getMutationsOfStudent');
  Route::get('/student/sibling', 'StudentController@getSiblingsOfStudent');
  Route::get('/student/{student_id}', 'StudentController@getStudentDetail');
  

  Route::get('/school', 'SchoolController@getSchoolsByFilters');
  Route::get('/school/option', 'SchoolController@getSchoolOptions');
  Route::post('/school', 'SchoolController@createSchool');
  Route::put('/school', 'SchoolController@updateSchool');
  Route::delete('/school', 'SchoolController@deleteSchools');


  Route::get('/tahun-pelajaran', 'TahunPelajaranController@getTahunPelajaransByFilters');
  Route::get('/tahun-pelajaran/option', 'TahunPelajaranController@getTahunPelajaranOptions');
  Route::post('/tahun-pelajaran', 'TahunPelajaranController@createTahunPelajaran');
  Route::put('/tahun-pelajaran', 'TahunPelajaranController@updateTahunPelajaran');
  Route::delete('/tahun-pelajaran', 'TahunPelajaranController@deleteTahunPelajarans'); 

  //units
  Route::get('/unit', 'UnitController@data');
  Route::get('/unit/option', 'UnitController@getForOptions');
  Route::post('/unit', 'UnitController@store');
  Route::post('/unit/employee', 'UnitController@storeOfEmployes');
  Route::get('/unit/{id}', 'UnitController@edit');
  Route::put('/unit', 'UnitController@update');
  Route::delete('/unit', 'UnitController@destroy');

  
    //users
  Route::get('/user', 'UserController@getStudentsByFilters');
  Route::get('/user/by-token', 'UserController@getUserByToken');
  Route::get('/user/option', 'UserController@getForOptions');
  Route::get('/user/unit', 'UserController@getUnitOfUser');
  Route::get('/user/role', 'UserController@getRoleOfUser');
  Route::put('/user/unit', 'UserController@addUnit');
  Route::get('/user/my', 'UserController@myUser');
  Route::post('/user', 'UserController@store');
  Route::post('/user/employee', 'UserController@storeOfEmployes');
  Route::put('/user/employee', 'UserController@updateOfEmployes');  
  Route::put('/user/change-password', 'UserController@changePassword');
  Route::put('/user/reset-password', 'UserController@resetPassword');
  Route::get('/user/{id}', 'UserController@edit');
  Route::put('/user', 'UserController@update');
  Route::put('/user/role', 'UserController@addRole');
  Route::delete('/user', 'UserController@destroy');
  Route::delete('/user/role', 'UserController@deleteRoleOfUser');

  // //Blood Group 
  // Route::get('/blood-group/option', 'BloodGroupController@getBloodGroupOptions');

  //Diagnosis BMI 
  Route::post('/diagnosis-bmi/create', 'DiagnosisBMIController@createDiagnosisBMI');
  Route::get('/diagnosis-bmi/option', 'DiagnosisBMIController@getDiagnosisBMIOptions');
  Route::put('/diagnosis-bmi/update', 'DiagnosisBMIController@updateDiagnosisBMI');
  Route::delete('/diagnosis-bmi/delete', 'DiagnosisBMIController@deleteDiagnosisBMI');

  //Diagnosis General 
  Route::post('/diagnosis-general/create', 'DiagnosisGeneralController@createDiagnosisGeneral');
  Route::get('/diagnosis-general/option', 'DiagnosisGeneralController@getDiagnosisGeneralOptions');
  Route::put('/diagnosis-general/update', 'DiagnosisGeneralController@updateDiagnosisGeneral');
  Route::delete('/diagnosis-general/delete', 'DiagnosisGeneralController@deleteDiagnosisGeneral');

  //Diagnosis MCU 
  Route::post('/diagnosis-mcu/create', 'DiagnosisMCUController@createDiagnosisMCU');
  Route::get('/diagnosis-mcu/option', 'DiagnosisMCUController@getDiagnosisMCUOptions');
  Route::put('/diagnosis-mcu/update', 'DiagnosisMCUController@updateDiagnosisMCU');
  Route::delete('/diagnosis-mcu/delete', 'DiagnosisMCUController@deleteDiagnosisMCU');

  //Diagnosis Eyes 
  Route::post('/diagnosis-eyes/create', 'DiagnosisEyesController@createDiagnosisEyes');
  Route::get('/diagnosis-eyes/option', 'DiagnosisEyesController@getDiagnosisEyesOptions');
  Route::put('/diagnosis-eyes/update', 'DiagnosisEyesController@updateDiagnosisEyes');
  Route::delete('/diagnosis-eyes/delete', 'DiagnosisEyesController@deleteDiagnosisEyes');

  //UKS Officer Registration 
  Route::post('/uks-officer/create', 'UKSOfficerRegistrationController@createUKSOfficerRegistration');
  Route::get('/uks-location/option', 'UKSOfficerRegistrationController@getListUKSLocationOptions');
  Route::get('/uks-list-registration-location/option', 'UKSOfficerRegistrationController@getUKSOfficerRegistrationOptions');
  Route::put('/uks-officer/update', 'UKSOfficerRegistrationController@updateUKSOfficerRegistration');
  Route::delete('/uks-officer/delete', 'UKSOfficerRegistrationController@deleteUKSOfficerRegistration'); 

  //Student Current Health History
  Route::get('/student-current-health-history/option', 'StudentCurrentHealthHistoryController@getStudentCurrentHealthHistoryOptions');
  Route::post('/student-current-health-history/create', 'StudentCurrentHealthHistoryController@createStudentCurrentHealthHistory');
  Route::post('/student-current-health-history/update', 'StudentCurrentHealthHistoryController@updateStudentCurrentHealthHistory');
  Route::delete('/student-current-health-history/delete', 'StudentCurrentHealthHistoryController@deleteStudentCurrentHealthHistory');
  Route::get('/general-diagnosis/option', 'StudentCurrentHealthHistoryController@getGeneralDiagnosisOptions');

  //Employee Current Health History
  
  Route::post('/employee-current-health-history/create', 'EmployeeCurrentHealthHistoryController@createEmployeeCurrentHealthHistory');
  Route::get('/employee-current-health-history/option', 'EmployeeCurrentHealthHistoryController@getEmployeeCurrentHealthHistoryOptions');
  Route::get('/download-document', 'EmployeeCurrentHealthHistoryController@downloadDocument');
  Route::post('/employee-current-health-history/update', 'EmployeeCurrentHealthHistoryController@updateEmployeeCurrentHealthHistory');
  Route::delete('/employee-current-health-history/delete', 'EmployeeCurrentHealthHistoryController@deleteEmployeeCurrentHealthHistory');

  
  //Student Recap Diagnosis
  Route::get('/student-mcu-recap-diagnosis', 'StudentRecapDiagnosisController@dataMCU');
  Route::get('/student-treatment-recap-diagnosis', 'StudentRecapDiagnosisController@dataTreatment');
  Route::get('/export-excel-mcu-student', 'StudentRecapDiagnosisController@exportExcelMCU');
  Route::get('/export-excel-treatment-student', 'StudentRecapDiagnosisController@exportExcelTreatment');

   //Employee Recap Diagnosis
  Route::get('/employee-recap-diagnosis-treatment', 'EmployeeRecapDiagnosisController@dataTreatment');
  Route::get('/export-excel-treatment-employee', 'EmployeeRecapDiagnosisController@exportExcelTreatment');
  Route::get('/employee-recap-diagnosis-mcu', 'EmployeeRecapDiagnosisController@dataMCU');
  Route::get('/export-excel-mcu-employee', 'EmployeeRecapDiagnosisController@exportExcelMCU');
  
  //Student MCU 
  Route::get('/eye-visus/option', 'StudentMCUController@getEyeVisusOptions');
  Route::get('/bmi-diagnosis/option', 'StudentMCUController@getBMIDiagnosisOptions');
  Route::get('/mcu-diagnosis/option', 'StudentMCUController@getMCUDiagnosisOptions');
  Route::get('/eye-diagnosis/option', 'StudentMCUController@geteyeDiagnosisOptions');
  Route::get('/student-mcu/option', 'StudentMCUController@getStudentMCUOptions');
  Route::post('/student-mcu/create', 'StudentMCUController@createStudentMCU');
  Route::post('/student-mcu/update', 'StudentMCUController@updateStudentMCU');
  Route::delete('/student-mcu/delete', 'StudentMCUController@deleteStudentMCU');

  // Employee MCU 
  Route::get('/employee-mcu/option', 'EmployeeMCUController@getEmployeeMCUOptions');
  Route::post('/employee-mcu/create', 'EmployeeMCUController@createEmployeeMCU');
  Route::post('/employee-mcu/update', 'EmployeeMCUController@updateEmployeeMCU');
  Route::delete('/employee-mcu/delete', 'EmployeeMCUController@deleteEmployeeMCU');
  Route::get('/download-document', 'EmployeeMCUController@downloadDocument');

  //Student Treatment
  Route::get('/student-treatment/option', 'StudentTreatmentController@getStudentTreatmentOptions');
  Route::get('/reduce-stock', 'StudentTreatmentController@reduceStock');
  Route::post('/student-treatment/create', 'StudentTreatmentController@createStudentTreatment');
  Route::post('/student-treatment/update', 'StudentTreatmentController@updateStudentTreatment');
  Route::delete('/student-treatment/delete', 'StudentTreatmentController@deleteStudentTreatment');

  //Employee Treatment
  Route::get('/employee-treatment/option', 'EmployeeTreatmentController@getEmployeeTreatmentOptions');
  Route::post('/employee-treatment/create', 'EmployeeTreatmentController@createEmployeeTreatment');
  Route::post('/employee-treatment/update', 'EmployeeTreatmentController@updateEmployeeTreatment');
  Route::delete('/employee-treatment/delete', 'EmployeeTreatmentController@deleteEmployeeTreatment');
  Route::get('/download-document', 'EmployeeTreatmentController@downloadDocument');

  // Employee Unit 
  Route::get('/employee-unit/option', 'EmployeeUnitController@option');

  //Drug
  Route::post('/drug/create', 'DrugController@createDrug');
  Route::post('/drug/update', 'DrugController@updateDrug');
  Route::delete('/drug/delete', 'DrugController@deleteDrug');
  Route::get('/drug/option', 'DrugController@getDrugOptions');
  Route::get('/location-drug/option', 'DrugController@getLocationDrugOptions');
  Route::get('/uks-location/option', 'DrugController@getListUKSLocationOptions');
  Route::get('/drug-recap/option', 'DrugRecapController@getDrugRecapOptions');
  Route::get('/export', 'DrugRecapController@export');
  Route::get('/export-excel-drug-in', 'DrugController@export');


  //Drug Distribution
  Route::get('/drug-distribution/option', 'DrugController@getDrugDistributionOptions');
  Route::get('/drug-distribution/', 'DrugController@getDrugDistributionSettings');
  Route::post('/drug-distribution/create', 'DrugController@createDrugDistributionSettings');
  Route::post('/drug-distribution/update', 'DrugController@updateDrugDistributionSettings');
  Route::delete('/drug-distribution/delete', 'DrugController@deleteDrugDistributionSettings');

  //Drug Mutation
  Route::post('/drug-mutation/create', 'DrugMutationController@createDrugMutation');
  Route::post('/drug-mutation/update', 'DrugMutationController@updateDrugMutation');
  Route::get('/drug-mutation/option', 'DrugMutationController@getDrugMutationOptions');
  Route::get('/export-excel-drug-mutation', 'DrugMutationController@export');

  //Drug Type
  Route::post('/drug-type/create', 'DrugTypeController@createDrugType');
  Route::get('/drug-type/option', 'DrugTypeController@getDrugTypeOptions');
  Route::put('/drug-type/update', 'DrugTypeController@updateDrugType');
  Route::delete('/drug-type/delete', 'DrugTypeController@deleteDrugType');

  //Drug Location
  Route::post('/drug-location/create', 'DrugLocationController@createDrugLocation');
  Route::get('/drug-location/option', 'DrugLocationController@getDrugLocationOptions');
  Route::put('/drug-location/update', 'DrugLocationController@updateDrugLocation');
  Route::delete('/drug-location/delete', 'DrugLocationController@deleteDrugLocation');

  //Drug Name
  Route::post('/drug-name/create', 'DrugNameController@createDrugName');
  Route::get('/drug-name/option', 'DrugNameController@getDrugNameOptions');
  Route::put('/drug-name/update', 'DrugNameController@updateDrugName');
  Route::delete('/drug-name/delete', 'DrugNameController@deleteDrugName');

  //Drug Unit
  Route::post('/drug-unit/create', 'DrugUnitController@createDrugUnit');
  Route::get('/drug-unit/option', 'DrugUnitController@getDrugUnitOptions');
  Route::put('/drug-unit/update', 'DrugUnitController@updateDrugUnit');
  Route::delete('/drug-unit/delete', 'DrugUnitController@deleteDrugUnit');

  //Email Notification
  Route::get('/email/option', 'EmailController@getDataEmail');
  Route::get('/email-student/option', 'EmailController@getstudentEmailOptions');
  Route::get('/email-employee/option', 'EmailController@getemployeeEmailOptions');
  Route::post('/email-notification-student', 'EmailController@sendEmailStudent');
  Route::post('/email-notification-employee', 'EmailController@sendEmailEmployee');

});
