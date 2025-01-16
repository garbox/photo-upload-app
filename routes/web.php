<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/upload/{session?}', [PhotoController::class, 'showForm']);
Route::post('/upload', [PhotoController::class, 'upload']);