<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ShiftController;

class SecurityShiftCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending security code to notify the shift is over ';

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
        $x = new ShiftController();
        $x->securityNotification(); 
        \Log::info('Security code Cron is working');

    }
}
