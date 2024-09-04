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
        'image_id', // For storing cover images
    ];

    protected $casts = [
        'content' => 'array', // JSON content will be casted to php array
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class); // many-to-many
    }

    public function coverImage() {
        return $this->belongsTo(Image::class, 'image_id'); // one-to-many
    }

    // Remove 'images' from $with if the relationship is unnecessary
    protected $with = ['tags', 'coverImage'];

    static function validate(Request $request) {
        $post = $request->method() === 'POST';
        return $request->validate([
            'title' => [$post ? 'required' : 'sometimes', 'min:1', 'max:200'],
            'content' => [$post ? 'required' : 'sometimes', 'json'],
            'image_id' => ['nullable', 'exists:images,id'], // Validate cover_image_id
        ]);
    }
}