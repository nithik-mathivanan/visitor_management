<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FeedDelte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto delete un used feeds';

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
        \Log::info('Feed Delete CRON running!!');
        return 0;
    }
}
