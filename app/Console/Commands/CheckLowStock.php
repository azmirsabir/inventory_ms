<?php

namespace App\Console\Commands;

use App\Jobs\CheckLowStockJob;
use Illuminate\Console\Command;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:check-low-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and process low stock inventory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      CheckLowStockJob::dispatch();
      
      $this->info('Low stock check job dispatched successfully.');
    }
}
