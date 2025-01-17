<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    // store photo info on server to pull via Async
    public function photoUplaod(){

    }

    public static function photoDelete(){
        // Get the current time minus 2 hours
        $twoHoursAgo = Carbon::now()->subHours(2);

        // Query for records older than 2 hours
        $oldRecords = Photo::where('created_at', '<', $twoHoursAgo)->get();

        // Loop through the old records and delete associated files
        foreach ($oldRecords as $record) {
            // Delete the file from storage (assuming the file path is stored in 'file_path')
            if (Storage::exists('photos/' . $record->filename)) {
                Storage::delete('photos/' . $record->filename);
            }
            else{
                dump('no file found');
            }

            // Delete the record from the database
            $record->delete();
        }
    }
}
