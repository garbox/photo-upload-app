<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RemoveExpiredPhotosJob;

class RemoveExpiredPhotosCommand extends Command
{
    protected $signature = 'photos:remove-expired';
    protected $description = 'Remove expired photos from the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Dispatch the job to the queue
            RemoveExpiredPhotosJob::dispatch();

            $this->info('Expired photos removal job has been dispatched successfully!');
        } catch (\Exception $e) {
            $this->error('Error dispatching the photo removal job: ' . $e->getMessage());
        }
    }
}
