<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Importer;
use App\Workday;

class WorkdaysImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wsg:workdayimporter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Workdays table Importing command';

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
        // enter file path here
        //$filepath = storage_path('imports\workday_01_12_05_2020.csv');
        $filepath = storage_path('imports/development_import/workdays.ods');
        if (!file_exists($filepath)) {
            $this->error('Workday File - File Does not exist - ' . $filepath);
            return;
        }
        $this->info('Starting the import ......' . $filepath);
        //$excel = Importer::make('Csv');
        $excel = Importer::make('OpenOffice');
        $excel->hasHeader(true);
        $excel->load($filepath);
        $data = $excel->getCollection();

        //print_r($data); return;

        $i = 1;
        $this->info('CSV Converted to array ......');
        if (!empty($data) && $data->count()) {
            $this->info('Data existed, let\'s import it ......');
            foreach ($data as $key) {

                // company_id field
                if (!$key['company_id']) {
                    $this->warn('skipping record due to null company_id ..... - ' . $i++);
                    continue;
                } else {
                    $company_id = $key['company_id'];
                }

                // day field
                if (!$key['day']) {
                    $this->warn('skipping record due to null day ..... - ' . $i++);
                    continue;
                } else {
                    $day = $key['day'];
                }

                $open_time = (!$key['open_time']) ? '09:00' : $key['open_time'];
                $close_time = (!$key['close_time']) ? '12:00' : $key['close_time'];

                $insert[] = [
                    'company_id' => $company_id,
                    'day' => $day,
                    'open_time' => $open_time,
                    'close_time' => $close_time,
                    'created_at' => date('Y-m-d H:m:s'),
                    'updated_at' => date('Y-m-d H:m:s'),
                ];

                $i++;
            }
            if (!empty($insert)) {
                try {
                    Workday::insert($insert);
                    $this->info('Successfully imported the Workdays.');
                } catch (\Illuminate\Database\QueryException $qe) {
                    $this->error($qe->getMessage());
                }
            }
        }
    }
}
