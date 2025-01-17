<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Models\Photo;

// Show the photo upload form (assuming you have a controller for this route)
Route::get('/', [PhotoController::class, 'index']);
Route::get('mobile/{session}', [PhotoController::class, 'index']);

// Handle photo upload
Route::post('/upload', [PhotoController::class, 'upload']);

// Fetch photos based on session ID and return them as JSON
Route::get('/photos', [PhotoController::class, 'getPhotoAsync']);