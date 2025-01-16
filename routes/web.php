<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Models\Photo;

// Show the photo upload form (assuming you have a controller for this route)
Route::get('/', [PhotoController::class, 'showForm']);
Route::get('mobile/{session}', [PhotoController::class, 'showForm']);

// Handle photo upload
Route::post('/upload', [PhotoController::class, 'upload']);

// Fetch photos based on session ID and return them as JSON
Route::get('/photos', function() {
    // Get photos by session ID
    $photos = Photo::where('session_id', session()->getId())->get();
        
    // Return the photos as a JSON response
    return response()->json($photos);
});