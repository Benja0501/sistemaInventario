<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// todos los días a las 8:00 AM.
Schedule::command('inventory:check-expirations')->dailyAt('08:00');