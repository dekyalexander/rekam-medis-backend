<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_distributions', function (Blueprint $table) {
            $table->id();
            $table->integer('drug_id')->nullable();
            $table->integer('drug_type_id')->nullable();
            $table->integer('drug_name_id')->nullable();
            $table->integer('drug_unit_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('drug_expired_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('qty')->nullable();
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
        Schema::dropIfExists('drug_distributions');
    }
}
