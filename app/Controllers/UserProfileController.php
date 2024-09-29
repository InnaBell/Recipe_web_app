<?php

namespace App\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserProfileController {
    function index(Request $request) {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'User profile not found'], 404);
        }

        return response()->json($profile, 200);
    }

    public function update(Request $request) {
        $user = Auth::user();
        $profile = UserProfile::where('user_id',  $user->id)->firstOrFail();  // Search for the profile

        $payload = $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:255',
        ]);

        // Avatar update
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($profile->avatar) {
                Storage::delete('public/' . $profile->avatar);
            }

            // Store new avatar in public/avatars
            $avatar = $request->file('avatar');
            $avatarPath = 'avatars/' . Str::random(16) . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public', $avatarPath);

            // Update the avatar path in the database
            $profile->avatar = $avatarPath;
        }

        if (isset($payload['bio'])) {
            $profile->bio = $payload['bio'];
        }

        $profile->save();

        return response()->json($profile, 200);
    }

    function destroy(Request $request) {
        $id = $request->input('id');
        $profile = UserProfile::findOrFail($id);

        if ($profile->avatar) {
            Storage::delete('public/' . $profile->avatar);
        }

        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }
}

