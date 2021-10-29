<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TablesCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Tables';

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
        Wish::truncate();
        \Log::info("Table Cleaned");
    }
}
