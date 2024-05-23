<?php

namespace App\Console\Commands;

use App\Models\AuthLog;
use Illuminate\Console\Command;

class AuthLogTableTruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auth-log-table-truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate the auth logs table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AuthLog::whereDate('created_at', now()->subMonths(3))->delete();
        $this->info('Auth Logs Table truncated successfully!');
    }
}
