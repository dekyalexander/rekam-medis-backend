<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMCUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_mcus', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('niy',10);
            $table->string('level',10);
            $table->string('kelas',10);
            $table->string('school_year',10)->nullable();
            $table->date('inspection_date');
            $table->string('od_eyes',10)->nullable();
            $table->string('os_eyes',10)->nullable();
            $table->string('color_blind',10)->nullable();
            $table->string('blood_pressure',10)->nullable();
            $table->string('pulse',10)->nullable();
            $table->string('respiration',10)->nullable();
            $table->string('temperature',10)->nullable();
            $table->text('dental_occlusion')->nullable();
            $table->text('tooth_gap')->nullable();
            $table->text('crowding_teeth')->nullable();
            $table->text('dental_debris')->nullable();
            $table->text('tartar')->nullable();
            $table->text('tooth_abscess')->nullable();
            $table->text('tongue')->nullable();
            $table->text('other')->nullable();
            $table->text('suggestion')->nullable();
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
        Schema::dropIfExists('student_mcus');
    }
}
