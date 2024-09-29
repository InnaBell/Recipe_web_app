<?php

namespace App\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController
{
	public function index()
	{
		return Category::all();
	}

	public function create(Request $request)
	{
		$request->validate([
			'name' => 'required|unique:categories|max:255',
		]);

		$category = Category::create($request->all());

		return response()->json($category, 201);
	}

	public function assign(Request $request)
	{
		$recipeId = $request->input('recipe_id');
		$categoryIds = $request->input('category_ids');
		$recipe = Auth::user()->recipes()->findOrFail($recipeId);
		$recipe->categories()->sync($categoryIds);
		$recipe->save();
		return $recipe->fresh();
	}
}
