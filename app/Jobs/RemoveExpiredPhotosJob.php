<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class RemoveExpiredPhotosJob extends Jobs
{
    use Queueable;

    public function __construct(){
    }

    public function handle(): void{
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
                Log::info('no file found');
            }

            // Delete the record from the database
            $record->delete();
        }
    }
}
