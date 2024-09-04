<?php

namespace App\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagsController {
  function index(Request $request) {
    return Tag::all();
  }

  function create(Request $request) {
    $payload = Tag::validate($request);
    return Tag::create($payload);
  }

  function assign(Request $request) {
    $recipeId = $request->input('recipe_id');
    $tagIds = $request->input('tag_ids');
    $recipe = Auth::user()->recipes()->findOrFail($recipeId);
    $recipe->tags()->sync($tagIds);
    $recipe->save();
    return $recipe->fresh();
  }
}
