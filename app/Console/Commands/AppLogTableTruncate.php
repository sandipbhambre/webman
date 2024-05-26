<?php

namespace App\Console\Commands;

use App\Models\AppLog;
use Illuminate\Console\Command;

class AppLogTableTruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:app-log-table-truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate the app logs table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AppLog::whereDate('created_at', now()->subMonths(3))->delete();
        $this->info('App Logs Table truncated successfully!');
    }
}
