<?php
namespace App\Models;

use Bootstrap\Column;
use Bootstrap\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class UserProfile extends Model {
	#[Column] public int $id;
	#[Column] public int $user_id;
	#[Column] public string|null $avatar;
	#[Column] public string|null $bio;
	#[Column] public string $created_at;
	#[Column] public string $updated_at;

	function user(): BelongsTo|User {
		return $this->belongsTo(User::class);
	  }
	
	  static function validate(Request $request) {
		return $request->validate([
			'avatar' => ['nullable', 'image', 'max:2048'], // 2 MB
			'bio' => ['nullable', 'string', 'max:255'],
		]);
	  }

	}