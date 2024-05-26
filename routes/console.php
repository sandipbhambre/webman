<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command('auth:clear-resets')->everyFifteenMinutes();
Schedule::command('app:auth-log-table-truncate')->quarterly();
Schedule::command('app:app-log-table-truncate')->quarterly();
