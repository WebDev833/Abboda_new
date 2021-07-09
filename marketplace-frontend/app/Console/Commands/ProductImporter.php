<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\Front;
use Config;
use Importer;
Use Illuminate\Support\Facades\Log;

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

        // Import CSV to Database
          $filepath = storage_path('imports/newdata/products.csv');
        $excel = Importer::make('Csv');$excel->hasHeader(true);$excel->load($filepath);
        $data = $excel->getCollection();
       
        if (!empty($data) && $data->count()) {
            foreach ($data as $value) {
              $campObj= \App\Models\Company::where('slug','=',trim($value['slug']))->first('id');

              if(!is_null($campObj)){ //company if already have

      ///category import
                $categoryObj= \App\Models\Category::where('company_id','=',$campObj->id)
                ->where('name','=',trim($value['category']))
                ->first('id');
                if(!is_null($categoryObj)){
                   
      ///Product import
                 $productObj=\App\Models\Product::where('name','=',trim($value['menu_name']))
                ->where('company_id','=', $campObj->id)
                ->first('id');
                if(is_null($productObj)){
                    $productObj = new App\Models\Product;
                }
                $productObj->company_id = $campObj->id;
                $productObj->category_id = $categoryObj->id;
                $productObj->name = trim($value['menu_name']);
                $productObj->price = is_numeric($value['price']) ? $value['price'] : 0;
                $productObj->description =$value['description'];
                $productObj->imageUrl=$value['image'];
                $productObj->save();
                }//if category have.

              }///if compnay have
            }// for each product Data
          }//if data exist end
          $this->info('Product import DONE');
          Log::info('Product import DONE');

          return true;
exit;

//below is the old code.


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
