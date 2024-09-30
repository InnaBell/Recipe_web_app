<?php

namespace App\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipesController {
    function index(Request $request) {
        $query = Recipe::with(['tags', 'coverImage', 'categories']); // Only eager load cover image, not all images

        // filter by title
        $title = $request->input('title');
        if ($title) $query->where('title', 'like', "%$title%");

        // filter by user
        $userId = $request->input('user_id');
        if ($userId) $query->where('user_id', $userId);

        // filter by tags
        $tagIds = $request->input('tag_ids');
        if ($tagIds) {
            $tagIds = explode(',', $tagIds);
            $query->whereHas(
                'tags',
                fn($q) => $q->whereIn('tag_id', $tagIds),
                '>=',
                count($tagIds)
            );
        }

        // order
        $orderBy = $request->input('order_by', 'created_at'); // order by id, created_at, updated_at, ...
        $orderDir = $request->input('order_dir', 'desc'); // desc - new first, asc - old first
        $query->orderBy($orderBy, $orderDir);

        // limit, offset
        $limit = $request->input('limit'); // limit = 10 - return 10 results
        $offset = $request->input('offset'); // offset = 10 - skip 10 results and start with the 11th
        if ($limit) $query->limit($limit);
        if ($offset) $query->offset($offset);

		// filter by categories
		$categoryIds = $request->input('category_ids');
		if ($categoryIds) {
		$categoryIds = explode(',', $categoryIds);
		$query->whereHas(
		'categories',
		fn($q) => $q->whereIn('category_id', $categoryIds)
	);
}

		// return the results
		return $query->get();
	}

    function create(Request $request) {
        // Convert content JSON object to string if it's an array
        if (is_array($request->input('content'))) {
            $request->merge([
                'content' => json_encode($request->input('content')),
            ]);
        }

        $payload = Recipe::validate($request);

        // Handle cover image validation as before
        if ($request->has('image_id')) {
            $coverImage = Auth::user()->images()->find($request->input('image_id'));

            if (!$coverImage) {
                return response()->json(['error' => 'Invalid cover image ID.'], 422);
            }

            $payload['image_id'] = $coverImage->id;
        }

        $recipe = Auth::user()->recipes()->create($payload);

		// Attach categories
		if ($request->has('category_ids')) {
			$recipe->categories()->sync($request->input('category_ids'));
		}

		// Load related tags, cover image, and categories
		$recipe->load(['tags', 'coverImage', 'categories']);

		// Return the recipe with related data
		return response()->json($recipe, 200);
    }

    function update(Request $request) {
      $id = $request->input('id');
      $recipe = Auth::user()->recipes()->findOrFail($id);
  
      // Convert content JSON object to string if it's an array
      if (is_array($request->input('content'))) {
          $request->merge([
              'content' => json_encode($request->input('content')),
          ]);
      }
  
      $payload = Recipe::validate($request);
  
      // Handle cover image validation
      if ($request->has('cover_image_id')) {
          $coverImageId = $request->input('cover_image_id');
          $coverImage = Auth::user()->images()->findOrFail($coverImageId); 
  
          if (!$coverImage) {
              return response()->json(['error' => 'Invalid cover image ID.'], 422);
          }
  
          $payload['cover_image_id'] = $coverImage->id;
      }
  
      $recipe->update($payload);

		// Attach categories
		if ($request->has('category_ids')) {
			$recipe->categories()->sync($request->input('category_ids'));
		}

		$recipe->load(['tags', 'coverImage', 'categories']);

		return response()->json($recipe, 200);
  }

    function destroy(Request $request) {
        $id = $request->input('id');
        $recipe = Auth::user()->recipes()->findOrFail($id);
        $recipe->delete();
        return $recipe;
    }
}