<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Photo;  // Assuming File is the model for the table
use Illuminate\Support\Facades\Storage;  // To handle file deletion
use Carbon\Carbon;

class RemoveExpiredPhotos implements ShouldQueue
{
    use Queueable;
    
    public function __construct(){
        //
    }

    /**
     * Execute the job.
     */
    public function handle(){

        // Get the current time minus 2 hours
        $twoHoursAgo = Carbon::now()->subHours(2);

        // Query for records older than 2 hours
        $oldRecords = Photo::where('created_at', '<', $twoHoursAgo)->get();

        // Loop through the old records and delete associated files
        foreach ($oldRecords as $record) {
            // Delete the file from storage (assuming the file path is stored in 'file_path')
            if (Storage::exists(asset('storage/photos/'.$record->filename))) {
                Storage::delete(asset('storage/photos/'.$record->filename));
            }

            // Delete the record from the database
            $record->delete();
        }
    }
}
