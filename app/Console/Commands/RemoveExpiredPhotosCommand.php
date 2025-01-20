<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RemoveExpiredPhotosJob;
use Carbon\Carbon;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 

class RemoveExpiredPhotosCommand extends Command
{
    protected $signature = 'photos:remove-expired';
    protected $description = 'Remove expired photos from the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
            // Get the current time minus 2 hours
            $twoHoursAgo = Carbon::now()->subHours(2);

            // Query for records older than 2 hours
            $oldRecords = Photo::where('created_at', '<', $twoHoursAgo)->get();

            // Loop through the old records and delete associated files
            foreach ($oldRecords as $record) {
                // Delete the file from storage (assuming the file path is stored in 'filename')
                if (Storage::exists('photos/' . $record->filename)) {
                    Storage::delete('photos/' . $record->filename);
                } else {
                    // Logging when no file is found
                    Log::info('No file found for photo with filename: ' . $record->filename);
                }

                // Delete the record from the database
                $record->delete();
            }
        }
}