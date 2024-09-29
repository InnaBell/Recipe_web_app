<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		// main table
		Schema::create('categories', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->timestamps();
		});

		// pivot table
		Schema::create('category_recipe', function (Blueprint $table) {
			$table->foreignId('category_id')->constrained()->onDelete('cascade');
			$table->foreignId('recipe_id')->constrained()->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::dropIfExists('category_recipe');
		Schema::dropIfExists('categories');
	}
};

