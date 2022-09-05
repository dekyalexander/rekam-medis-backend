<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name',50);
            $table->string('ktp',50)->nullable();
            $table->string('nkk',20)->nullable();
            $table->string('email',50)->nullable();
            $table->string('mobilePhone',50)->nullable();
            $table->date('birth_date')->nullable();
            $table->tinyInteger('sex_type_value');
            $table->tinyInteger('parent_type_value');
            $table->tinyInteger('wali_type_value')->nullable();
            $table->string('job')->nullable();
            $table->string('jobCorporateName',50)->nullable();
            $table->string('jobPositionName',30)->nullable();
            $table->string('jobWorkAddress')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('provinsi_id')->nullable();
            $table->tinyInteger('kota_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->integer('kelurahan_id')->nullable();
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
        Schema::dropIfExists('parents');
    }
}
