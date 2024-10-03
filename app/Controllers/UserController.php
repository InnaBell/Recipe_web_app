<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\UserProfile; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController {
function show() {
	$user = Auth::user()->load('profile');

	if (!$user) {
		return response()->json(['error' => 'User not authenticated'], 401);
	}

	return response()->json([
		'user' => $user
	], 200);
}

function create(Request $request) {
	$payload = User::validate($request);
	$user = User::create($payload);

	$profilePayload = $request->validate([
		'avatar' => 'nullable|image|max:2048',
		'bio' => 'nullable|string|max:255',
	]);

	$profile = new UserProfile($profilePayload);
	$profile->user_id = $user->id;
	$profile->save();

	return response()->json(['user' => $user, 'profile' => $profile], 201);
}

function update(Request $request) {
	$user = Auth::user();
	$payload = User::validate($request, $user->id);
	$user->update($payload);
	return $user;
}

function destroy(Request $request) {
	$user = Auth::user();
	$user->delete();
	return $user;
}
}
