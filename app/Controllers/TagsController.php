<?php

namespace App\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;

class TagsController {
	function index(Request $request) {
		$recipeId = $request->input('recipe_id');
		$recipe = Recipe::findOrFail($recipeId);
		$tags = $recipe->tags;
		return response()->json($tags, 200);
	  }
	
	  // To show all tags 
	  function show() {
		$tags = Tag::all();
		return response()->json($tags, 200);
	  }

	  function create(Request $request) {
		$payload = Tag::validate($request);
		return Tag::create($payload);
	  }

  function assign(Request $request) {
	$recipeId = $request->input('recipe_id');
	$tagIds = $request->input('tag_ids');

	if (!$tagIds || !is_array($tagIds)) {
		return response()->json(['error' => 'Tag IDs are required and should be an array'], 400);
	}

	$recipe = Auth::user()->recipes()->findOrFail($recipeId);
	$recipe->tags()->attach($tagIds);
	$recipe->save();
	return response()->json($recipe->fresh('tags'), 200);
  }
}
