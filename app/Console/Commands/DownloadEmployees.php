<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WishController;

class DownloadEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downaload All Employees From The API';

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
        $wishController = new WishController();
        $wishController->DonwloadEmployee();
        \Log::info("Download Employees");
    }
}
