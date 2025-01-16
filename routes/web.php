<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Models\Photo;

Route::get('/{session?}', [PhotoController::class, 'showForm']);
Route::post('/upload', [PhotoController::class, 'upload']);
Route::get('/photos', function() {
    $photos = Photo::where('session_id', session()->getId())->get();
    return json($photos);
});