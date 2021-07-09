<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

use App\Models\Company;
Use Illuminate\Support\Facades\Log;

class ImageLinkComp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	
	 
    protected $signature = "scrap:ImageLinkComp";
	protected $user_command_name = "ImageLinkComp"; 
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
        $campObj=\App\Models\Company::where('coverImgUrl','<>','done')->where('coverImgUrl','<>','')->take(15)->get(['coverImgUrl','id']);
        if($campObj){

        foreach ($campObj as $camp_obj) {
          $media = $camp_obj->getFirstMedia('store_images');
            
          if($media == ""){
          if(!empty($camp_obj->coverImgUrl) && file_exists(storage_path('imports/'.$camp_obj->coverImgUrl))){
          $camp_obj
                ->addMedia(storage_path('imports/'.$camp_obj->coverImgUrl))
                ->preservingOriginal()
                ->toMediaCollection('store_images');
            
            $camp_obj->coverImgUrl='done';
            $camp_obj->save();

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
		
    }
	
		
}
