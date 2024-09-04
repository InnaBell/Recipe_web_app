<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  function up() {
    // main table
    Schema::create('tags', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });

    // pivot table
    Schema::create('recipe_tag', function (Blueprint $table) {
      $table->id();
      $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
      $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    });
  }

  function down() {
    Schema::dropIfExists('tags');
    Schema::dropIfExists('recipe_tag');
  }
};
