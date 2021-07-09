<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

use App\Models\Company;
use App\ModelsByBabar\TempRestaurant;
class ImageFilterEGYPT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	
	 
    protected $signature = "scrap:egypt_img";
	protected $user_command_name = "egypt_img"; 
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

	// $image_path = 'D:/WorkPlace/Fiverr/hanygan/images/';
	
    public function handle(Request $request)
    {
      $fileName = "D:/WorkPlace/images.csv";
      $fileNamex = "images/details_file.csv";
      $file_w = fopen($fileNamex,'w');
      $file = fopen($fileName,'r');
      $image_path = 'images/';



      while (($line = fgetcsv($file)) !== FALSE) 
         {
            $name = $line[0];

            echo "Checking ".$name." \n";

            if($line[2] == '')
               $img = $line[1];
            else
               $img = $line[2];


               $company = Company::where('name',$name)->first();
			   
               if(count((array)$company) == 0)
               {
                  echo "SKIPPING ".$name." \n";
                  goto skip;
               }

            echo "Geting ".$name." \n";
               
            $filenxme = preg_replace('/[^A-Za-z0-9\- ]/', '', $name);;
            $filenxme = preg_replace('/ /', '_', $filenxme);;
            $filenxme = strtolower($filenxme).".jpg";

            fputcsv($file_w,array($company->id,$name,$filenxme));

            $exact_file_location = $image_path.$filenxme;

            if(!file_exists($exact_file_location))
            {
               $content = $this->download($img);
               file_put_contents($exact_file_location,$content);
            }

            skip:

         }
      fclose($file);
      fclose($file_w);
      return;
      $fileName = "D:/WorkPlace/images.csv";
		$file = fopen($fileName,'w');
      
     
	
       echo "Fetching raw Data \n";
        $temps = TempRestaurant::get();
        echo "Fetching raw Data DONE\n";
        foreach($temps as $temp)
        {
           echo "Test.\n";
           echo $temp->id."\n";

           $json_body = json_decode($temp->json_of);//coverPhoto
           
           
           $logo = $json_body->logo;
           $logo = str_replace("{{PHOTO_VERSION}}","Normal",$logo);
           $logo = str_replace("{{PHOTO_EXTENSION}}","jpg",$logo);

           $coverPhoto = $json_body->coverPhoto;
           $coverPhoto = str_replace("{{PHOTO_VERSION}}","Normal",$coverPhoto);
           $coverPhoto = str_replace("{{PHOTO_EXTENSION}}","jpg",$coverPhoto);

           echo "CoverIMG: $coverPhoto\n";
           echo "LogoIMG: $logo\n";

           fputcsv($file,array($json_body->name,$logo,$coverPhoto));
           
        }
        echo "Processing raw Data DONE\n";

        fclose($file);	
    }
	
	public function download($url)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}
		
}
