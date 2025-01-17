<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index($session = null){
        // Get the session ID
        if($session !== null){
            session()->setId($session);
        }
        else{
            session()->getId();
        }

        //get photos if any
        $photosData = Photo::where('session_id', session()->getId())->get();

        // Redirect to another route and append session ID as a query parameter
        return view('upload', ['photos' => $photosData]);
    }

    public function upload(Request $request){
        // Validate the uploaded file
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            ], 
            [
                'photo.required' => 'A photo is required.',
                'photo.image' => 'The uploaded file must be an image.',
                'photo.mimes' => 'The image must be a JPEG, PNG, JPG, or GIF.',
                'photo.max' => 'The image must not be greater than 5MB.',
            ]);

        // Store the image
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filePath = $file->store('photos', 'public');
            
            Photo::insert([
                'session_id' => session()->getId(),
                'filename' => $file->hashName(),
            ]);

            return back()->with('success', 'Photo uploaded successfully')->with('file', $filePath);
        }

        return back()->withErrors('No file uploaded');
    }

    public function getPhotoAsync(){
        // Get photos by session ID
        $photos = Photo::where('session_id', session()->getId())->get();

        // Return the photos as a JSON response
        return response()->json($photos);
    }
}

