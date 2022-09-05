<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('father_parent_id')->nullable();
            $table->bigInteger('mother_parent_id')->nullable();
            $table->bigInteger('father_employee_id')->nullable();
            $table->bigInteger('mother_employee_id')->nullable();
            $table->bigInteger('wali_parent_id')->nullable();
            $table->bigInteger('wali_employee_id')->nullable();
            $table->tinyInteger('jenjang_id')->nullable();
            $table->tinyInteger('school_id')->nullable();
            $table->tinyInteger('kelas_id')->nullable();
            $table->integer('parallel_id')->nullable();
            $table->tinyInteger('masuk_tahun_id')->nullable();
            $table->tinyInteger('masuk_jenjang_id')->nullable();
            $table->tinyInteger('masuk_kelas_id')->nullable();
            $table->tinyInteger('is_father_alive')->default(1);
            $table->tinyInteger('is_mother_alive')->default(1);
            $table->tinyInteger('is_poor')->default(0);
            $table->string('nis')->nullable();
            $table->string('niy')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nkk')->nullable();
            $table->string('father_ktp')->nullable();
            $table->string('mother_ktp')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->tinyInteger('sex_type_value');
            $table->text('address')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('photo')->nullable();
            $table->string('handphone')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->tinyInteger('birth_order')->default(1);
            $table->tinyInteger('religion_value')->nullable();
            $table->string('nationality')->nullable();
            $table->string('language')->nullable();
            $table->tinyInteger('is_adopted')->default(0);
            $table->tinyInteger('stay_with_value')->default(1);
            $table->tinyInteger('siblings')->default(0);
            $table->tinyInteger('is_sibling_student')->default(0);
            $table->tinyInteger('foster')->default(0);
            $table->tinyInteger('step_siblings')->default(0);
            $table->string('medical_history')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('student_status_value')->default(1);
            $table->tinyInteger('lulus_tahun_id')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->char('gol_darah',3)->nullable();
            $table->tinyInteger('is_cacat')->default(0);
            $table->tinyInteger('tinggi')->default(0);
            $table->tinyInteger('berat')->default(0);
            $table->string('sekolah_asal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
