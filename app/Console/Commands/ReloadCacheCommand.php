<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReloadCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload caches.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('route:clear');
        $this->call('route:cache'); // use this if you don't have any closure based route
        $this->call('optimize:clear');
    }
}
