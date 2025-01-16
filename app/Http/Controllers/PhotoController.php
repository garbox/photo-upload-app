<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function showForm($session = null){
                // Get the session ID
                if($session != null){
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
}

