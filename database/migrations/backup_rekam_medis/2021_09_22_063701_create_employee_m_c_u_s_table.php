<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMCUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_mcus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('inspection_date');
            $table->string('head');
            $table->string('neck');
            $table->string('eye');
            $table->string('nose');
            $table->string('tongue');
            $table->string('tooth');
            $table->string('gum');
            $table->string('throat');
            $table->string('ear');
            $table->string('lymph_nodes_and_neck');
            $table->string('heart');
            $table->string('lungs');
            $table->string('epigastrium');
            $table->string('hearts');
            $table->string('spleen');
            $table->string('intestines');
            $table->string('urogenital_system');
            $table->string('hand');
            $table->string('foot');
            $table->string('skin');
            $table->string('diagnosis');
            $table->text('suggestion');
            $table->text('description');
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
        Schema::dropIfExists('employee_mcus');
    }
}
