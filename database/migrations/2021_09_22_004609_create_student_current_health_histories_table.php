<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCurrentHealthHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_current_health_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('niy',10);
            $table->string('level',10);
            $table->string('kelas',10);
            $table->string('blood_group',10)->nullable();
            $table->string('blood_group_rhesus',10)->nullable();
            $table->string('history_of_drug_allergy',50)->nullable();
            $table->string('covid19_illness_history',10)->nullable();
            $table->date('covid19_sick_date')->nullable();
            $table->string('covid19_vaccine_history',10)->nullable();
            $table->text('covid19_vaccine_description')->nullable();
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
        Schema::dropIfExists('student_current_health_histories');
    }
}
