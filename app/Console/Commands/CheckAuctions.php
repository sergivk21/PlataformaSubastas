<?php

namespace App\Console\Commands;

use App\Jobs\FinalizeAuctions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class CheckAuctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auctions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa y finaliza subastas que hayan terminado';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Queue::push(new FinalizeAuctions());
        $this->info('Revisando subastas finalizadas...');
    }
}
