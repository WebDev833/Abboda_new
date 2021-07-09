<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\Front;
use Config;
use Importer;

class ProductImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wsg:productimporter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product table Importing command';

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
        $filepath = storage_path('imports/development_import/products.ods');
        if (!file_exists($filepath)) {
            $this->error('Product File - File Does not exist - ' . $filepath);
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

                // category_id field
                if (!$key['category_id']) {
                    $this->warn('skipping record due to null category_id ..... - ');
                    continue;
                } else {
                    $category_id = $key['category_id'];
                }

                // name field
                if (!$key['name']) {
                    $this->warn('skipping record due to null name ..... - ');
                    continue;
                } else {
                    $name = $key['name'];
                }

                // price field
                if (!$key['price']) {
                    $price = config('romsimporter.defaultproductprice'); // price null
                } else {
                    $price = $key['price'];
                }

                // description field
                if (!$key['description']) {
                    $description = $key['name']; // description null -> set to name for default.
                } else {
                    $description = $key['description'];
                }

                // active field
                $active = (!$key['active']) ? 0 : $key['active'];
                $in_stock = (!$key['in_stock']) ? 0 : $key['in_stock'];

                // company_image field
                $filepath = (!$key['product_image']) ? false : $key['product_image'];

                $productObj = new \App\Models\Product;
                $productObj->company_id = $company_id;
                $productObj->category_id = $category_id;
                $productObj->name = $name;
                $productObj->price = $price;
                $productObj->in_stock = (bool) $in_stock;
                $productObj->active = (bool) $active;
                $productObj->description = $description;
                $productObj->save();

                if (!$filepath) {
                    $this->warn('Product image does not exist ... ' . $productObj->id);
                    continue;
                }
                $this->info('Calling image upload to the import ......' . $filepath);
                Front::relateMedia($filepath, 'product_image', $productObj);
            }
        }
    }
}
