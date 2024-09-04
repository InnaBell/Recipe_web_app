<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Image;

// faker: https://fakerphp.github.io/formatters/text-and-paragraphs/

class DatabaseSeeder extends Seeder {
  function run() {
    // users
    ////////////////////////////////////////////////////////////////////////////
    User::create([
      'email' => 'alpha@mailinator.com',
      'password' => 'password',
    ]);

    User::create([
      'email' => 'bravo@mailinator.com',
      'password' => 'password',
    ]);

    User::create([
      'email' => 'charlie@mailinator.com',
      'password' => 'password',
    ]);

    // Recipes
    ////////////////////////////////////////////////////////////////////////////
    for ($i = 0; $i < 10; $i++) {
      Recipe::create([
        'title' => fake()->word(),
        'content' => fake()->sentence(),
        'user_id' => 1,
      ]);
    }

    // comments
    ////////////////////////////////////////////////////////////////////////////////
    for ($i = 0; $i < 20; $i++) {
      Comment::create([
        'text' => fake()->sentence(3),
        'recipe_id' => random_int(1, 10),
        'user_id' => random_int(1, 3),
      ]);
    }

    // tags
    ////////////////////////////////////////////////////////////////////////////////
    for ($i = 0; $i < 10; $i++) {
      Tag::create(['name' => fake()->word()]);
    }

  }
}
