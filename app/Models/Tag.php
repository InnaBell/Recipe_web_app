<?php

namespace App\Models;

use Bootstrap\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tag extends Model {
	use HasFactory;

    protected $fillable = ['name'];

	public function recipes() {
		return $this->belongsToMany(Recipe::class); // many-to-many
	}

	static function validate(Request $request) {
    return $request->validate([
      'name' => ['required', 'min:1', 'max: 99', 'unique:tags,name'], // das Feld "name" soll unique sein
    ]);
  }
}
