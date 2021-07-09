<?php

namespace App\Console\Commands;

use App\Helpers\Front;
use Illuminate\Console\Command;
use Importer;

class CategoriesImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wsg:categoryimporter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'category table Importing command';

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
        $filepath = storage_path('imports/development_import/categories.ods');
        if (!file_exists($filepath)) {
            $this->error('Category File - File Does not exist - ' . $filepath);
            return;
        }
        $this->info('Fielpath ......' . $filepath);
       // $excel = Importer::make('Csv');
        $excel = Importer::make('OpenOffice');
        $excel->hasHeader(true);
        $excel->load($filepath);
        $data = $excel->getCollection();
        $this->info('CSV Converted to array ......');
        if (!empty($data) && $data->count()) {
            $this->info('Data existed, let\'s import it ......');
            foreach ($data as $key) {
                // company_id field
                if (!$key['company_id']) {
                    $this->warn('skipping record due to null company_id ..... - ');
                    continue;
                } else {
                    $company_id = $key['company_id'];
                }

                // name field
                if (!$key['name']) {
                    $this->warn('skipping record due to null name ..... - ');
                    continue;
                } else {
                    $name = $key['name'];
                }

                // active field
                $active = (!$key['active']) ? 0 : $key['active'];

                // category_image field
                $filepath = (!$key['category_image']) ? false : $key['category_image'];

                $catObj = new \App\Models\Category;
                $catObj->company_id = $company_id;
                $catObj->name = $name;
                $catObj->active = (bool) $active;
                $catObj->save();

                if (!$filepath) {
                    $this->warn('Category image does not exist ... ' . $catObj->id);
                    continue;
                }
                $this->info('Calling image upload to the import ......' . $filepath);
                Front::relateMedia($filepath, 'category_image', $catObj);
            }
        }
    }
}
