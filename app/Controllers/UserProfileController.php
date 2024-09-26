<?php

namespace App\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController {
    function index(Request $request) {
        $query = UserProfile::query();

        $userId = $request->input('user_id'); // Filter by user_id
        if ($userId) $query->where('user_id', $userId);

        $query->orderBy('created_at', 'desc'); // Filter by date of creation

        return $query->get();
    }

    function create(Request $request) {
        $payload = $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id', // Connect user_id to user
        ]);

        return UserProfile::create($payload);
    }

    public function update(Request $request) {
		$userId = $request->input('user_id');
		$profile = UserProfile::where('user_id', $userId)->firstOrFail();  // To find the profile of the user
		
		$payload = $request->validate([
			'avatar' => 'nullable|image|max:2048',
			'bio' => 'nullable|string|max:255',
		]);
		
		$profile->update($payload);
	
		return response()->json($profile, 200); // Return the updated profile
	}

    function destroy(Request $request) {
        $id = $request->input('id');
        $profile = UserProfile::findOrFail($id);
        $profile->delete();
        return $profile;
    }
}
