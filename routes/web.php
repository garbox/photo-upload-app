<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Models\Photo;

Route::get('/{session?}', [PhotoController::class, 'showForm']);
Route::post('/upload', [PhotoController::class, 'upload']);
