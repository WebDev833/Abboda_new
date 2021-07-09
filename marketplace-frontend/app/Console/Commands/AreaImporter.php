<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;

use Importer;
use App\Area;

class AreaImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wsg:areaimporter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Area table Importing command';

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
        $filepath = storage_path('imports\imp_01_19_05\areas-arabic-test.ods');
        if (!file_exists($filepath)) {
            $this->error('Area File - File Does not exist - ' . $filepath);
            return;
        }
        $this->info('Starting the import ......' . $filepath);
        //$excel = Importer::make('Csv');
        $excel = Importer::make('OpenOffice');
        $excel->hasHeader(true);
        $excel->load($filepath);
        $data = $excel->getCollection();
       // print_r($data);
       // return;
        $i = 1;
        $this->info('CSV Converted to array ......');
        if (!empty($data) && $data->count()) {
            $this->info('Data existed, let\'s import it ......');
            foreach ($data as $key) {

                // name field
                if (!$key['name']) {
                    $this->warn('skipping record due to null name ..... - ' . $i++);
                    continue;
                } else {
                    $name = $key['name'];
                }

                // active field
                $active = (!$key['active']) ? 0 : $key['active'];

                $insert[] = [
                    'city_id' => 1, // for now its static :) 1
                    'name' => $name,
                    'active' => (bool) $active,
                    'created_at' => date('Y-m-d H:m:s'),
                    'updated_at' => date('Y-m-d H:m:s'),
                ];

                $i++;
            }
            if (!empty($insert)) {
                try {
                    Area::insert($insert);
                    $this->info('Successfully imported the areas.');
                } catch (\Illuminate\Database\QueryException $qe) {
                    $this->error($qe->getMessage());
                }
            }
        }
    }
}
