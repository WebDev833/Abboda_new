<?php

namespace App\Console\Commands;

use App\Helpers\Front;
use Config;
use Illuminate\Console\Command;
use Importer;
Use Illuminate\Support\Facades\Log;

class CompanyImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wsg:companyimporter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Companies table Importing command';

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
        $filepath = storage_path('imports/newdata/resturants.csv');
        $excel = Importer::make('Csv');
        $excel->hasHeader(true);
        $excel->load($filepath);
        $data = $excel->getCollection();
        
        if (!empty($data) && $data->count()) {
            foreach ($data as $value) {
              
                $companytype_id=1;
                $area_id=0;
                $name=$value['name'];
                $description='';
                $email='';
                $phone=$value['phone'];
                $rating=$value['average_rating'];
                $slug=$value['slug'];
                $latitude=$value['latitude'];
                $longitude=$value['longitude'];
                $address=$value['address'];
                $active=1;
                $catalog_enabled=1;
                $Sunday=$value['Sunday'];
                $Monday=$value['Monday'];
                $Tuesday=$value['Tuesday'];
                $Wednesday=$value['Wednesday'];
                $Thursday=$value['Thursday'];
                $Friday=$value['Friday'];
                $Saturday=$value['Saturday'];
                $country=$value['country_short'];
                $state=$value['state'];
                $city=$value['city'];

                $Dayarr=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

                $campObj=\App\Models\Company::where('slug','=',$value['slug'])->first();
                
                if(is_null($campObj)){
                    $campObj = new \App\Models\Company;
                }            
                $campObj->companytype_id = $companytype_id;
                $campObj->area_id = $area_id;
                $campObj->name = $name;
                $campObj->description = $description;
                $campObj->email = $email;
                $campObj->phone = $phone;
                $campObj->rating = is_numeric($rating) ?$rating : 0;
                $campObj->slug = $slug;
                $campObj->latitude = $latitude;
                $campObj->longitude = $longitude;
                $campObj->address = $address;
                $campObj->active = (bool) $active;
                $campObj->catalog_enabled = (bool) $catalog_enabled;
                $campObj->coverImgUrl=$value['logo'];
                $campObj->country = $country;
                $campObj->state = $state;
                $campObj->city = $city;
                
                $campObj->save();

                ///image import
                /*
                $media = $campObj->getFirstMedia('store_images');
                if(is_null($media)){
                  if(file_exists(storage_path('imports/'.$value['logo']))){
                    Front::relateMedia(storage_path('imports/'.$value['logo']), 'store_images', $campObj);
                }}*/

          ///days Importer
        foreach ($Dayarr as $day) {
              if(!empty($value[$day])){
              $HoursArr =explode("-",$value[$day]);
              $open_time =$HoursArr[0];
              $close_time =$HoursArr[1];
            
              $dayObj=\App\ModelsByBabar\WorkDay::where('company_id', '=', $campObj->id)
              ->where('day', '=',$day)->first();
              if(is_null($dayObj)){
                $dayObj = new \App\ModelsByBabar\WorkDay;
              }
              $dayObj->company_id=$campObj->id;
              $dayObj->day=$day;
              $dayObj->open_time=$open_time;
              $dayObj->close_time=$close_time;
              $dayObj->save();
              }//if empty day end

              }//for each end day
            }// for each compnay data
          }//if data exist end
          $this->info('resturants import DONE');
          Log::info('resturants import DONE');
          return true;
      exit;

        // enter file path here
        //$filepath = storage_path('imports\imp_01_19_05\companies.csv');
        //$filepath = storage_path('imports\imp_01_19_05\companies.xlsx');
        $filepath = storage_path('imports/development_import/companies.ods');
        if (!file_exists($filepath)) {
            $this->error('Company File - File Does not exist - ' . $filepath);
            return;
        }
        $this->info('Fielpath ......' . $filepath);
        //$excel = Importer::make('Csv');
        $excel = Importer::make('OpenOffice');
        //$excel = Importer::make('Excel');
        $excel->hasHeader(true);
        $excel->load($filepath);
        $data = $excel->getCollection();
        $this->info('CSV Converted to array ......');
       // print_r($data);
        //return;
        if (!empty($data) && $data->count()) {
            $this->info('Data existed, let\'s import it ......');
            foreach ($data as $key) {

                // companytype_id field
                if (!$key['companytype_id']) {
                    $this->warn('skipping record due to null companytype_id ..... - ');
                    continue;
                } else {
                    $companytype_id = $key['companytype_id'];
                }

                // area_id field
                if (!$key['area_name']) { /// change for data guys - area_id
                    $this->warn('skipping record due to null area_id ..... - ');
                    continue;
                } else {

                  /*
                  here need to find the area by name 
                  if exist then use the ID if not 
                  then create one and then use that id.

                  Newly added code below..
                  */

                  $area = \App\Area::where(['name'=>$key['area_name']])->first();
                  if(is_null($area))
                  {
                     $newArea = new \App\Area;
                     $newArea->city_id = 1;
                     $newArea->name = $key['area_name']; // here area_id is name actually 
                     $newArea->active = 1;
                     $newArea->save();
                     $area_id = $newArea->id;
                  } else 
                  {
                    // area already exist -> grab the id
                    $area_id = $area->id;
                  }                 
                }

                // name field
                if (!$key['name']) {
                    $this->warn('skipping record due to null name ..... - ');
                    continue;
                } else {
                    //$name = utf8_encode($key['name']);
                    $name = $key['name'];
                }

                // description field
                if (!$key['description']) {
                   // $description = utf8_encode($key['name']); // description null -> set to name for default.
                    $description = $key['name']; // description null -> set to name for default.
                   
                } else {
                 //   $description = utf8_encode($key['description']);
                    $description = $key['description'];
                }

                // email field
                if (!$key['email']) {
                    $email = config('romsimporter.defaultemail'); // email null -> set to system email default.
                } else {
                   // $email = utf8_encode($key['email']);
                    $email = $key['email'];
                }

                // phone field
                if (!$key['phone']) {
                    $phone = config('romsimporter.defaultphone'); // email null -> set to system email default.
                } else {
                    $phone = $key['phone'];
                }

                // rating field
                if (!$key['rating']) {
                    $rating = config('romsimporter.defaultrating'); // rating null -> set to system rating default.
                } else {
                    $rating = intval($key['rating']);
                }
                // slug field
                if (!$key['slug']) {
                    $slug = Front::mySlugify($name . '-' . rand(1,99999));
                } else {
                    $slug = Front::mySlugify($key['slug']);
                }

                // latitude field
                if (!$key['latitude']) {
                    $latitude = config('romsimporter.defaultcairolat');
                } else {
                    $latitude = $key['latitude'];
                }

                // longitude field
                if (!$key['longitude']) {
                    $longitude = config('romsimporter.defaultcairolon');
                } else {
                    $longitude = $key['longitude'];
                }
                // address field
                if (!$key['address']) {
                    $address = config('romsimporter.defaultaddress');
                } else {
                    $address = $key['address'];
                }
                // active field
                $active = (!$key['active']) ? 0 : $key['active'];
                $catalog_enabled = (!$key['catalog_enabled']) ? 0 : $key['catalog_enabled'];

                // company_image field
                $filepath = (!$key['company_image']) ? false : $key['company_image'];
                
                $campObj = new \App\Models\Company;
                $campObj->companytype_id = $companytype_id;
                $campObj->area_id = $area_id;
                $campObj->name = $name;
                $campObj->description = $description;
                $campObj->email = $email;
                $campObj->phone = $phone;
                $campObj->rating = $rating;
                $campObj->slug = $slug;
                $campObj->latitude = $latitude;
                $campObj->longitude = $longitude;
                $campObj->address = $address;
                $campObj->active = (bool) $active;
                $campObj->catalog_enabled = (bool) $catalog_enabled;
                $campObj->save();

                if (!$filepath) {
                    $this->warn('Company image does not exist ... ' . $campObj->id);
                    continue;
                }
                $this->info('Calling image upload to the import ......' . $filepath);
                Front::relateMedia($filepath, 'company_image', $campObj);
            }
        }
    }
}
