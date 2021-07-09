<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      
        Commands\CallRoute::class,
        Commands\ImportData::class,

        // Importer commands
        Commands\AreaImporter::class,
        Commands\CompanyImporter::class,
        Commands\WorkdaysImporter::class,
        Commands\CategoriesImporter::class,
        Commands\ProductImporter::class,
        Commands\hanygan_2::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
		/*
        $schedule->command('scrap:hanygan_2')
         ->timezone('Asia/Karachi')
         ->yearlyOn(1, 18, '14:00');
		*/
     
         $schedule->command('scrap:imagelink')
         ->timezone('Asia/Karachi')
         ->everyMinute();
        $schedule->command('scrap:ImageLinkComp')
         ->timezone('Asia/Karachi')
         ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
