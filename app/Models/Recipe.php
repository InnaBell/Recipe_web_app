<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Recipe extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'content', // This will hold the JSON content
        'user_id',
        'image_id',
		'is_published',
		'servings',
		'cooking_time',
    ];

    protected $casts = [
        'content' => 'array', // JSON content will be casted to php array
		'is_published' => 'boolean',
		'servings' => 'integer',
		'cooking_time' => 'integer',
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class); // many-to-many
    }

    public function coverImage() {
        return $this->belongsTo(Image::class, 'image_id'); 
    }

    // Remove 'images' from $with if the relationship is unnecessary
    protected $with = ['tags', 'coverImage'];

    static function validate(Request $request) {
        $post = $request->method() === 'POST';
        return $request->validate([
            'title' => [$post ? 'required' : 'sometimes', 'min:1', 'max:200'],
            'content' => [$post ? 'required' : 'sometimes', 'json'],
            'image_id' => ['exists:images,id'],
			'is_published' => ['boolean'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'cooking_time' => ['nullable', 'integer', 'min:1'],
        ]);
    }
}