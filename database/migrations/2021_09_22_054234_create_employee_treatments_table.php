<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('nik',10)->nullable();
            $table->string('unit',20)->nullable();
            $table->date('inspection_date');
            $table->text('anamnesa')->nullable();
            $table->text('head')->nullable();
            $table->text('neck')->nullable();
            $table->text('eye')->nullable();
            $table->text('nose')->nullable();
            $table->text('tongue')->nullable();
            $table->text('tooth')->nullable();
            $table->text('gum')->nullable();
            $table->text('throat')->nullable();
            $table->text('tonsils')->nullable();
            $table->text('ear')->nullable();
            $table->text('lymph_nodes_and_neck')->nullable();
            $table->text('heart')->nullable();
            $table->text('lungs')->nullable();
            $table->text('epigastrium')->nullable();
            $table->text('hearts')->nullable();
            $table->text('spleen')->nullable();
            $table->text('intestines')->nullable();
            $table->text('hand')->nullable();
            $table->text('foot')->nullable();
            $table->text('skin')->nullable();
            $table->text('description')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('employee_treatments');
    }
}
