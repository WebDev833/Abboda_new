<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

use App\Models\Company;

class ImageLinkCorrection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	
	 
    protected $signature = "scrap:imagere";
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
		$fileName = storage_path('app/public/tucson.csv');
		
		$file = fopen($fileName,'r');
		$key_x = 0;
		
		while (($line = fgetcsv($file)) !== FALSE) {
		   //$line[0] = '1004000018' in first iteration
		  if($key_x++ > 0)
		  {
			
			   $company = Company::where('name',$line[1])->first();
			   
			   if(count((array)$company) == 0)
			   {
				   echo "SKIPPING ".$line[1]." \n";
				   goto skip;
			   }
			   $media = $company->getFirstMedia('store_images');
			
				if($media == "")
				{
					echo "adding ".$line[1]." \n";
					
					$company
				   ->addMedia('public/storage/store_images/'.$line[2])
					->preservingOriginal()
				   ->toMediaCollection('store_images');
				}
				skip:
		  }
		   
		}
		fclose($file);
		
		
		
		
		
		
		   
		
    }
	
		
}
