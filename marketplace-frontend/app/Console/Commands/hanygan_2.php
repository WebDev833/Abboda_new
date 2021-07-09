<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\ModelsByBabar\City;
use App\ModelsByBabar\Area;
use App\ModelsByBabar\Zone;
use App\ModelsByBabar\Company;
use App\ModelsByBabar\Category;
use App\ModelsByBabar\Product;
use App\ModelsByBabar\WorkDay;
use App\ModelsByBabar\TempRestaurant;

class hanygan_2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	
	 
    protected $signature = "scrap:hanygan_2";
	protected $user_command_name = "hanygan_2"; 
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
		echo "Script Started\n";
		$start = 4900;
		//$end = $start + 202;
		
		$datas = TempRestaurant::
		//join('areas','area_key','=','area_uuid')
		//->select('areas.id','json_of','temp_restaurant_data.id as myid')
		where('temp_restaurant_data.id','>',$start)
		//->where('temp_restaurant_data.id','<',$end)
		->orderBy('id','asc')
		//->limit(1)
		->get();
		echo "Data Retrived\n";
		foreach($datas as $key_r => $data)
		{
			echo $key_r."\n";
			echo $data->id."\n";
			$this->parseRawDataSingle($data->json_of);
			//break;
		}
		echo "Script Finished\n";			
    }
	
		
	public function parseRawDataSingle($datax)
	{
		/*$data = \App\TempRestaurant::where('search_key','3q54')
		->join('areas','area_key','=','area_uuid')
		->select('areas.id','json_of')
		->first();*/
		$json_data = json_decode($datax,true);
		echo "Processing\n";
		
		$company_data = array();
		
		$company_data['companytype_id'] = 1;
		$company_data['name'] = $json_data['data']['storepageFeed']['storeHeader']['name'];
		$company_data['area_id'] = 0; // NOT FOUND
		$company_data['description'] = $json_data['data']['storepageFeed']['storeHeader']['description'];
		$company_data['phone'] = '';
		$company_data['email'] = '';
		$company_data['latitude'] = 0.0;
		$company_data['longitude'] = 0.0;
		$company_data['rating'] = $json_data['data']['storepageFeed']['storeHeader']['ratings']['averageRating'];
		$company_data['slug'] = $json_data['data']['storepageFeed']['storeHeader']['id'];
		$company_data['address'] = $json_data['data']['storepageFeed']['storeHeader']['address']['displayAddress'];
		$company_data['coverImgUrl'] = $json_data['data']['storepageFeed']['storeHeader']['coverImgUrl'];
		
		// save company here and get company_id
		
		$company_m = Company::where(['slug' => $json_data['data']['storepageFeed']['storeHeader']['id']])->first();
		
		if(count((array) $company_m) == 0)
		{
			$company_m = new Company();
			$company_m->fill($company_data);
			$company_m->save();
		}
		echo "Company Data Saved\n";
		$company_id = $company_m->id;
		
		// workdays database management
		
		$dailyWorkingHours =  explode("-",$json_data['data']['storepageFeed']['menuBook']['displayOpenHours']);
		
		$alsdskfds = "";
		if(isset($dailyWorkingHours[0]))
		{
			$alsdskfds = $dailyWorkingHours[0];
		}
		$alsdskfde = "";
		if(isset($dailyWorkingHours[1]))
		{
			$alsdskfde = $dailyWorkingHours[1];
		}
		
		$work_days_data = [
			'day' =>'Week',
			'open_time' => $alsdskfds,
			'close_time' => $alsdskfde,
			'company_id' => $company_id
			];
			
			$workday_m = WorkDay::where(['company_id' => $company_id,'day' => 'Week'])->first();
		
			if(count((array) $workday_m) == 0)
			{
				$workday_m = new WorkDay();
				$workday_m->fill($work_days_data);
				$workday_m->save();
			}
		
		echo "Workdays Data Saved\n";
		foreach($json_data['data']['storepageFeed']['itemLists'] as $menu)
		{
				
			$category_ = [
			'company_id' => $company_id,
			'name' => $menu['name'],
			//'cat_key' => '', // removed as per database field is removed....
			];
			
			// should have category_id here
			$category_m = Category::where(['name' => $menu['name'],'company_id' => $company_id])->first();
	
			if(count((array) $category_m) == 0)
			{
				$category_m = new Category();
				$category_m->fill($category_);
				$category_m->save();
			}
			$category_id = $category_m->id;
			
			echo "Category Saved Data Saved\n";
			foreach($menu['items'] as $item) // products
			{
				$product_ = [
					'sizeUUID' => $item['id'], // extra column to identify save new columns only....
					'company_id' => $company_id,
					'category_id' => $category_id,
					'name' => $item['name'],
					'imageUrl' => $item['imageUrl'],
					'price' => str_replace("$","",$item['displayPrice']),
					'description' => $item['description']
					];
					//print_r($product_);
					$product_m = Product::where(['sizeUUID' =>$item['id']])->count();
	
					if($product_m == 0)
					{
						$product_m = new Product();
						$product_m->fill($product_);
						$product_m->save();
					}			
			}
			echo "Product Saved Data Saved\n";
		}
		
		echo "All Done\n";
	}
		
}
