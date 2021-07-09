<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

use App\Models\Company;
Use Illuminate\Support\Facades\Log;

class ImageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	
	 
    protected $signature = "scrap:imagelink";
	protected $user_command_name = "ImageLink"; 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    { parent::__construct();
    }

	
	
    public function handle(Request $request)
    {

        try{
        $product=\App\Models\Product::where('imageUrl','<>','done')->where('imageUrl','<>','')->take(15)->get(['imageUrl','id']);
        if($product){

        foreach ($product as $product_obj) {
          $media = $product_obj->getFirstMedia('product_image');
            
          if($media == ""){
          if(!empty($product_obj->imageUrl) && file_exists(storage_path('imports/'.$product_obj->imageUrl))){
          $product_obj
                ->addMedia(storage_path('imports/'.$product_obj->imageUrl))
                ->preservingOriginal()
                ->toMediaCollection('product_image');
            
            $product_obj->imageUrl='done';
            $product_obj->save();

            }
          }
          //IMage parts
                /*$media = $productObj->getFirstMedia('product_image');
                if(is_null($media) && $value['image'] !=''){
                  if(file_exists(storage_path('imports/'.$value['image']))){
                    Front::relateMedia(storage_path('imports/'.$value['image']), 'product_image', $campObj);
                }}*/
          
        }
            
    }

      }
      catch(\Exception $e)
         {
             Log::error($e->getMessage());
         }

exit;
		$fileName = storage_path('app/public/tucson.csv');
		$fileName = storage_path('app/public/1companies.csv');
		$fileName = storage_path('app/details_file.csv');
		
		$file = fopen($fileName,'r');
		$key_x = 0;
		while (($line = fgetcsv($file)) !== FALSE) {
         //$line[0] = '1004000018' in first iteration
         try{
            if($key_x++ > 0)
            {
               echo "Added : $key_x\n";
             $company = Company::find($line[0]);
             $media = $company->getFirstMedia('store_images');
            
             if($media == "")
             {
                $company
                ->addMedia('public/storage/egypt_images/'.$line[2])
                ->preservingOriginal()
                ->toMediaCollection('store_images');
             }
             
             //$company->latitude = $line[5];
             //$company->longitude = $line[6];
             $company->save();
            }
         }
         catch(\Exception $e)
         {
            echo "Exception ".$e->getMessage()."\n";
         }
		
		   
		}
		fclose($file);
		
		
		
		
		
		
		   
		
    }
	
		
}
