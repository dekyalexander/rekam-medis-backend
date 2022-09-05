<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('approvals', function (Blueprint $table) {
      $table->id();
      $table->integer('action_id');
      $table->bigInteger('creator_id');
      $table->bigInteger('approver_role_id');
      $table->bigInteger('data_id');
      $table->string('data_table_name');
      $table->bigInteger('decider_id');
      $table->dateTime('decided_at');
      $table->integer('need_reason');
      $table->text('reason');
      $table->bigInteger('next')->nullable();
      $table->bigInteger('prev')->nullable();
      $table->tinyInteger('status')->nullable();
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
    Schema::dropIfExists('approvals');
  }
}
