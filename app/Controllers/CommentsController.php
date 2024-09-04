<?php

namespace App\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController {
  function index(Request $request) {
    $query = Comment::query();

    $userId = $request->input('user_id');
    if ($userId) $query->where('user_id', $userId);

    $recipeId = $request->input('recipe_id');
    if ($recipeId) $query->where('recipe_id', $recipeId);

    $query->orderBy('created_at', 'desc');

    return $query->get();
  }

  function create(Request $request) {
    $payload = Comment::validate($request);
    return Auth::user()->comments()->create($payload);
  }

  function update(Request $request) {
    $id = $request->input('id');
    $comment = Auth::user()->comments()->findOrFail($id);
    $payload = Comment::validate($request);
    $comment->update($payload);
    return $comment;
  }

  function destroy(Request $request) {
    $id = $request->input('id');
    $comment = Auth::user()->comments()->findOrFail($id);
    $comment->delete();
    return $comment;
  }
}
