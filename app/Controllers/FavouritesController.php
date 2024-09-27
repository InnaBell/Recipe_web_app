<?php

namespace App\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritesController {

	// Add or remove recipe from favourites
	public function toggle(Request $request) {
		$user = Auth::user();
		$recipeId = $request->input('recipe_id');

		// Check if the recipe is already in favourites
		$favourite = Favourite::where('user_id', $user->id)
							->where('recipe_id', $recipeId)
							->first();

		if ($favourite) {
			// If it is, remove it from favourites
			$favourite->delete();
			return response()->json(['message' => 'Recipe removed from favourites'], 200);
		} else {
			// If it isn't, add it to favourites
			$favourite = Favourite::create([
				'user_id' => $user->id,
				'recipe_id' => $recipeId,
			]);
			return response()->json(['message' => 'Recipe added to favourites', 'favourite' => $favourite], 201);
		}
	}

	// Get all favourites
	public function index(Request $request) {
	$user = Auth::user();

	// Get all favourites for the current user
	$favourites = Favourite::where('user_id', $user->id)
		 ->with(['recipe' => function($query) {
			$query->select('id', 'title', 'content', 'image_id');
		}])
		->get();

	return response()->json([
		'user_id' => $user->id,
		'favourites' => $favourites,
	], 200);
}

	// Get count of favourites for a specific recipe
	public function countFavouritesForRecipe(Request $request, $recipeId) {
		$count = Favourite::where('recipe_id', $recipeId)->count();
		return response()->json(['recipe_id' => $recipeId, 'favourites_count' => $count], 200);
	}
}


