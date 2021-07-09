<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wsg:importdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data for The System';

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
     * @return mixed
     */
    public function handle()
    {
        //$this->call('wsg:areaimporter'); // Area will automate from companies

        $this->call('wsg:companyimporter'); // working with first import

        $this->call('wsg:workdayimporter');

        $this->call('wsg:categoryimporter');

        $this->call('wsg:productimporter');

    }
}
