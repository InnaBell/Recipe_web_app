<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Image;
use App\Models\UserProfile;
use App\Models\Favourite;

class DatabaseSeeder extends Seeder {
  function run() {

	// Users + Profiles
	////////////////////////////////////////////////////////////////////////////
	for ($i = 0; $i < 10; $i++) {
		$user = User::create([
			'email' => fake()->unique()->safeEmail(),
			'password' => bcrypt('password'), // 
		]);

		UserProfile::create([
			'user_id' => $user->id, // Connect user_id to user
			'bio' => fake()->sentence(10),
			'avatar' => fake()->imageUrl(100, 100, 'people')
		]);
	}

	// Images
    ////////////////////////////////////////////////////////////////////////////
	for ($i = 0; $i < 10; $i++) {
		Image::create([
			'pathname' => fake()->imageUrl(),
			'user_id' => random_int(1, 3),
		]);
	  }

    // Recipes
    ////////////////////////////////////////////////////////////////////////////
	$userCount = User::count();
	$imageCount = Image::count(); 

	if ($userCount === 0 || $imageCount === 0) {
		$this->command->error("No users or images found");
		return;
	}

	for ($i = 0; $i < 10; $i++) {
		Recipe::create([
		'title' => fake()->word(),
		'content' => fake()->sentence(),
		'user_id' => random_int(1, $userCount),
		'image_id' => random_int(1, $imageCount),
		'is_published' => (bool)random_int(0, 1),
		'servings' => random_int(1, 6),
		'cooking_time' => random_int(10, 90),
		]);
	}

	// Comments
	////////////////////////////////////////////////////////////////////////////////
	for ($i = 0; $i < 10; $i++) {
		Comment::create([
		'text' => fake()->sentence(3),
		'recipe_id' => random_int(1, 10),
		'user_id' => random_int(1, 3),
		]);
	}

	// Tags
	////////////////////////////////////////////////////////////////////////////////
	for ($i = 0; $i < 10; $i++) {
		Tag::create(['name' => fake()->word()]);
	}

	// Favourites (Likes)
	////////////////////////////////////////////////////////////////////////////
		$recipeCount = Recipe::count();

		if ($recipeCount > 0 && $userCount > 0) {
		for ($i = 0; $i < 10; $i++) {
				Favourite::create([
					'user_id' => random_int(1, $userCount),
					'recipe_id' => random_int(1, $recipeCount),
				]);
			}
		}

	}
}
