<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  function up() {
    Schema::create('recipes', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->json('content'); // Store the JSON content here
      $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Delete all recipes when user is deleted
      $table->foreignId('image_id')->constrained('images')->cascadeOnDelete(); 
      $table->timestamps();
  });
}

  function down() {
    Schema::dropIfExists('recipes');
  }
};
