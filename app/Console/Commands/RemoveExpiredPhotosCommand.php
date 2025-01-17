<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Photo;

class RemoveExpiredPhotosCommand extends Command
{
    protected $signature = 'photos:remove-expired';  // Define a custom command signature
    protected $description = 'Remove expired photos from the database';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        // Dispatch the job when this command is run
        $test = Photo::photoDelete();

        $this->info($test);
    }
}
