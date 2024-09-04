<?php

use App\Controllers\RecipesController;
use App\Controllers\AuthController;
use App\Controllers\CommentsController;

use App\Controllers\MailsController;
use App\Controllers\TagsController;
use App\Controllers\UploadsController;
use App\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// guest endpoints
Route::post('/user', [UserController::class, 'create']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/recipes', [RecipesController::class, 'index']);
Route::get('/comments', [CommentsController::class, 'index']);
Route::get('/tags', [TagsController::class, 'index']);

// user endpoints
Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/user', [UserController::class, 'show']);
  Route::patch('/user', [UserController::class, 'update']);
  Route::delete('/user', [UserController::class, 'destroy']);

  Route::post('/auth/logout', [AuthController::class, 'logout']);

  Route::post('/recipes', [RecipesController::class, 'create']);
  Route::patch('/recipes', [RecipesController::class, 'update']);
  Route::delete('/recipes', [RecipesController::class, 'destroy']);

  Route::post('/comments', [CommentsController::class, 'create']);
  Route::patch('/comments', [CommentsController::class, 'update']);
  Route::delete('/comments', [CommentsController::class, 'destroy']);

  Route::post('/tags', [TagsController::class, 'create']);
  Route::put('/tags/assign', [TagsController::class, 'assign']);

  Route::post('/uploads', [UploadsController::class, 'create']);
  Route::delete('/uploads/{id}', [UploadsController::class, 'destroy']);

  Route::post('/mails/send', [MailsController::class, 'send']);
});










