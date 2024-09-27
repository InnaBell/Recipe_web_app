<?php

namespace App\Models;

use Bootstrap\Column;
use Bootstrap\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favourite extends Model {
	#[Column] public int $id;
	#[Column] public int $user_id;
	#[Column] public int $recipe_id;
	#[Column] public string $created_at;
	#[Column] public string $updated_at;

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	public function recipe(): BelongsTo {
		return $this->belongsTo(Recipe::class);
	}
}
