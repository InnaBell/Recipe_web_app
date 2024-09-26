<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   * This migration creates the "users" table.
   * @return void
   */

  function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('email');
      $table->string('password');
      $table->timestamps();
    });
  }

  /**
   * Revert the "users" table.
   * This method simply deletes the "users" table.
   * @return void
   */

  function down() {
    Schema::dropIfExists('users');
  }
};
