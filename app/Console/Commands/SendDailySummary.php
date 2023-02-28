<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommonController;
use Illuminate\Console\Command;

class SendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:dailysummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Summary of Reservations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $schedule = new CommonController();
        $schedule->send_daily_admin_report();
        $this->info('Success! Daily Summary Emails Sent.');
    }
}
