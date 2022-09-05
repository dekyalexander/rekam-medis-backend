<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParallels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parallels', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('jenjang_id');
            $table->tinyInteger('school_id');
            $table->tinyInteger('kelas_id');
            $table->tinyInteger('jurusan_id')->nullable();
            $table->string('name');
            $table->string('code',20)->nullable();
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
        Schema::dropIfExists('parallels');
    }
}
