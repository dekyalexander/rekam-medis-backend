<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMutation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_mutation', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('jenjang_id')->nullable();
            $table->tinyInteger('school_id')->nullable();
            $table->tinyInteger('kelas_id')->nullable();
            $table->integer('parallel_id')->nullable();
            $table->tinyInteger('tahun_pelajaran_id')->nullable();
            $table->string('nis')->nullable();
            $table->string('niy')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nkk')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('student_status_value')->default(1);
            $table->tinyInteger('tinggi')->default(0);
            $table->tinyInteger('berat')->default(0);
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
        Schema::dropIfExists('student_mutation');
    }
}
