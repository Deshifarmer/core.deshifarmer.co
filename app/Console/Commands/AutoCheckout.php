<?php

namespace App\Console\Commands;

use App\Models\v1\Attendance;
use Illuminate\Console\Command;

class AutoCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for auto checkout for those who forgot to checkout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Attendance::where('check_out', null)->update(['check_out' => now(), 'updated_at' => now(),'cout_note' => 'Forgot to check out']);
    }
}
