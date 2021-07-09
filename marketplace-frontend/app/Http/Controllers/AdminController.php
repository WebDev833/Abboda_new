<?php

namespace App\Http\Controllers;

use App\Area;
use App\AreaManager;
use App\Helpers\Admin;
use App\Helpers\Front;
use App\Http\Requests\Admin\CreateDriverRequest;
use App\Http\Requests\Admin\CreateManagerRequest;
use App\Http\Requests\Admin\CreatePageRequest;
use App\Http\Requests\Admin\CreateSectionRequest;
use App\Http\Requests\Admin\EditPageRequest;
use App\Http\Requests\Admin\EditSectionRequest;
use App\Http\Requests\Admin\UpdateDriverRequest;
use App\Http\Requests\Admin\UpdateManagerRequest;
use App\Http\Requests\Admin\CreateAreaRequest;
use App\Http\Requests\Admin\UpdateAreaRequest;
use App\Http\Requests\Admin\UpdateAdminProfile;
use App\Http\Requests\Admin\CreateCountryRequest; 
use App\Http\Requests\Admin\UpdateCountryRequest; 
use App\Http\Requests\Admin\CreateStateRequest; 
use App\Http\Requests\Admin\UpdateStateRequest; 
use App\Http\Requests\Admin\CreateCityRequest; 
use App\Http\Requests\Admin\UpdateCityRequest;
use App\Page;
use App\Section;
use App\User;
use App\Country;
use App\State;
use App\City;
use  App\Models\Company;
use App\CompanyType;
use  App\Models\Product;

use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use Importer;

class AdminController extends Controller
{
    /**
     * Max records in the page table.
     */
    private $maxPageRecords = 10;

    /**
     * Common page configs.
     */
    private $pageConfigs = [
        'title' => 'Home',
        'breadcrumb' => true,
    ];

    /**
     * Dashboard
     */
    /**
     * Pages
     * Orders
     * Users
     * Drivers
     * Managers
     * Companies
     * Areas
     * Products
     * Categories
     */
    public function dashboard()
    {
        $this->pageConfigs['title'] = 'Dashboard';
        $this->pageConfigs['breadcrumb'] = true;
        $items = [
          [
            'icon' => 'far fa-file-alt',
            'title' => 'Total Pages',
            'count' => Page::count(),
          ],
          [
            'icon' => 'fe fe-user',
            'title' => 'Total Managers',
            'count' => User::type(3)->count(),
          ],
          [
            'icon' => 'fe fe-user',
            'title' => 'Total Drivers',
            'count' => User::type(4)->count(),
          ],
          [
            'icon' => 'fe fe-user',
            'title' => 'Total Customers',
            'count' => User::type(5)->count(),
          ],
          [
            'icon' => 'fe fe-shopping-cart',
            'title' => 'Total Orders',
            'count' => \App\Order::count(),
          ],
          [
            'icon' => 'fe fe-grid',
            'title' => 'Total Categories',
            'count' => \App\Models\Category::count(),
          ],
          [
            'icon' => 'fe fe-box',
            'title' => 'Total Products',
            'count' => \App\Models\Product::count(),
          ],
          [
            'icon' => 'fe fe-map-pin',
            'title' => 'Total Areas',
            'count' => Area::count(),
          ],
        ];
        $orders = \App\Order::with([
            'orderstatus' => function ($q) {
                $q->select('id', 'name');
            },
            'company' => function ($q) {
                $q->select('id', 'name');
            },
            'area' => function ($q) {
                $q->select('id', 'name');
            },
            'user' => function ($q) {
                $q->select('id', 'name');
            },
        ])
        ->orderBy('id', 'DESC')
        ->limit(5)->get();

        return view('admin.pages.dashboard', [
            'pageConfigs' => $this->pageConfigs,
            'items'=> $items,
            'orders'=> $orders
        ]);
    }

    /**
     * resturnt import from file
     */
    public function restaurantsImport(request $request)
    {   
         $companytypes = CompanyType::active()
                  ->select('name','id')
                  ->orderBy('id', 'ASC')
                  ->get(); 
        return view('admin.pages.merchant.impoter', [
          'pageConfigs' => $this->pageConfigs,
          'companytypes' => $companytypes->pluck('name', 'id'),
      ]);
    }

    /**
     * resturnt import save file
     */
    public function restaurantsImportSave(Request  $request)
    {      
          if ($request->hasFile('csvfile')) {
              $file = $request->file('csvfile');
              // File Details 
              $filename = $file->getClientOriginalName();
              $extension = $file->getClientOriginalExtension();
              $tempPath = $file->getRealPath();
              $fileSize = $file->getSize();
              $mimeType = $file->getMimeType();
              // Valid File Extensions
              $valid_extension = array("csv");
               if(in_array(strtolower($extension),$valid_extension)){
                  // File upload location
                  $location = storage_path('imports/newdata');
                  // Upload file
                  $file->move($location,$filename);
                  //resturnt import
                  if($request->input('filetype') ==='1'){
                     $this->restaurantsImporter($request,$filename);
                    }elseif ($request->input('filetype') ==='2') {
                     $this->productImporter($request,$filename);
                  }                  
              }
            }//if csv file have
       return redirect(route('admin.restaurantsImport'))->with('success', 'Imported Successfully.');
   }
     public function productImporter($request,$filename)
    {
    
        // Import CSV to Database
          $filepath = storage_path('imports/newdata/'.$filename);
        $excel = Importer::make('Csv');$excel->hasHeader(true);$excel->load($filepath);
        $data = $excel->getCollection();
       
        if (!empty($data) && $data->count()) {
            foreach ($data as $value) {
              $campObj=Company::where('slug','=',trim($value['slug']))->first('id');

              if(!is_null($campObj)){ //company if already have

      ///category import
                $categoryObj= \App\Models\Category::where('company_id','=',$campObj->id)
                ->where('name','=',trim($value['category']))
                ->first('id');
                if(is_null($categoryObj)){
                    $categoryObj = new \App\Models\Category;
                    $categoryObj->name=trim($value['category']);
                    $categoryObj->company_id=$campObj->id;
                    $categoryObj->save();
                }
      ///Product import
                 $productObj=Product::where('name','=',trim($value['menu_name']))
                ->where('company_id','=', $campObj->id)
                ->first('id');
                if(is_null($productObj)){
                    $productObj = new Product;
                }
                $productObj->company_id = $campObj->id;
                $productObj->category_id = $categoryObj->id;
                $productObj->name = trim($value['menu_name']);
                $productObj->price = is_numeric($value['price']) ? $value['price'] : 0;
                $productObj->description =$value['description'];
                $productObj->imageUrl=$value['image'];
                $productObj->save();
                
                //IMage parts
                /*$media = $productObj->getFirstMedia('product_image');
                if(is_null($media) && $value['image'] !=''){
                  if(file_exists(storage_path('imports/'.$value['image']))){
                    Front::relateMedia(storage_path('imports/'.$value['image']), 'product_image', $campObj);
                }}*/
                
              }///if compnay have
            }// for each product data
          }//if data exist end
         
    }
//resturant file import  
  public function restaurantsImporter($request,$filename)
    {

        // Import CSV to Database
        $filepath = storage_path('imports/newdata/'.$filename);
        $excel = Importer::make('Csv');
        $excel->hasHeader(true);
        $excel->load($filepath);
        $data = $excel->getCollection();
        
        if (!empty($data) && $data->count()) {
            foreach ($data as $value) {
              
                $companytype_id=$request->input('companytype_id');
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

                $campObj=Company::where('slug','=',$value['slug'])->first();
                
                if(is_null($campObj)){
                    $campObj = new Company;
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

                /*$media = $campObj->getFirstMedia('store_images');
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
            
              $WorkDayObj = new \App\ModelsByBabar\WorkDay;
              $dayObj=$WorkDayObj::where('company_id', '=', $campObj->id)
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
    }


    public function addsubmerchant(Request $request)
    {
        $request->validate([
            'slug' => 'bail|required|unique:companies|max:255',
            
        ]);

        $mainmerchant= Company::where('id',$request->id)->first();
   
    $submerchant=Company::insert(
        ['slug' =>$request->slug,
        'latitude' =>$request->latitude , 
        'longitude' =>$request->longitude,
        'address'=>$request->address,
        'companytype_id'=>$mainmerchant->companytype_id,
        'area_id'=>$mainmerchant->area_id,
        'name'=>$mainmerchant->name,
        'description'=>$mainmerchant->description,
        'email'=>$mainmerchant->email,
        'phone'=>$mainmerchant->phone,
        'rating'=>$mainmerchant->rating,
        'parent_id'=>$mainmerchant->id]
     ); 
      return redirect(route('admin.editmerchant',$request->id))->with('success', 'Location Added Successfully.');

       
    }
    public function deletelocation(Company $id)
    {
        
        
   $id->delete();
        
        return redirect(route('admin.editmerchant',$id->parent_id))->with('success', 'Location deleted Successfully.');
    }



    /**
     * Admin Profile View
     */
    public function adminProfile()
    {
      $user = Auth::user();
      return view('admin.pages.admin.myprofile', [
          'pageConfigs' => $this->pageConfigs,
          'user'=> $user,
      ]);
    }

    /**
     * Admin Profile save
     */
    public function adminProfileSave(UpdateAdminProfile $request)
    {
      $user = Auth::user();
      $user->update($request->all());
      if ((request()->input('avatar') !== null) && request()->input('avatar')) {
          $cacheUpload = Admin::getByUuid(request()->input('avatar'));
          $mediaItem = $cacheUpload->getMedia('avatar')->first();
          $mediaItem->copy($user, 'avatar');
      }
      return redirect(route('admin.myprofile'))->with('success', 'Profile Updated Successfully.');
    }

    /**
     * Add Page
     */
    public function addPage()
    {
        $this->pageConfigs['title'] = 'Add Page';

        $sections = Section::active()->get();

        $countries = Country::orderBy('id', 'DESC')
            ->get();

    return view('admin.pages.pages.addpage', [
            'pageConfigs' => $this->pageConfigs,
            'sections' => $sections,
            'countries' => $countries->pluck('name','id'),
        ]);
    }

    /**
     * Add Page - POST
     * completed: false
     */
    public function addPageSave(CreatePageRequest $request)
    {
        $page_data = [
            'en' => [
                'title' => request()->input('title:en'),
                'slug' => Str::slug(request()->input('slug:en')),
            ],
            'ar' => [
                'title' => request()->input('title:ar'),
                'slug' => Str::slug(request()->input('slug:ar')),
            ],
            'status' => request()->input('status'),
            'static' => $request->has('static') ? request()->input('static') : 0,
            'country_id' => $request->has('country_id') ? request()->input('country_id') : 0,
        ];


        /*$page_data = [
            'title' => request()->input('title:en'),
            'slug' => Str::slug(request()->input('slug:en')),
            'status' => request()->input('status'),
        ];*/

        
        $page = Page::create($page_data);
      
        if (is_array(request()->input('sections'))) {
            $page->sections()->attach(request()->input('sections'));
        }
      
        return redirect(route('admin.addpage'))->with('success', 'Page Created Successfully.');
    }

    /**
     * Edit Page View
     */
    public function editPage(Page $page)
    {
        $this->pageConfigs['title'] = "Edit Page";

        $sections = Section::active()->get();
        $active = $page->sections->pluck('id');
        $countries = Country::orderBy('id', 'DESC')
            ->get();

        return view('admin.pages.pages.editpage', [
            'pageConfigs' => $this->pageConfigs,
            'page' => $page,
            'sections' => $sections,
            'active' => $active,
            'countries' => $countries->pluck('name','id'),
        ]);
    }

    /**
     * Edit Page Save
     */
    public function editPageSave(EditPageRequest $request, Page $page)
    {
        $data=$request->all();
       $data['static'] = $request->has('static') ? request()->input('static') : 0;
      $data['country_id'] = $request->input('country_id') !=null ? request()->input('country_id') : "0";
        $page->update($data);
        if (is_array(request()->input('sections'))) {
            $page->sections()->detach();
            $page->sections()->attach(request()->input('sections'));
        } else {
            $page->sections()->detach();
        }
        return redirect(route('admin.editpage', $page->id))->with('success', 'Page Updated successfully.');
    }

    /**
     * All Pages
     */
    public function allPages()
    {
        $this->pageConfigs['title'] = 'All Pages';
        $pages = Page::static(0)
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.pages.allpages', [
            'pageConfigs' => $this->pageConfigs,
            'pages' => $pages,
        ]);
    }

    /**
     * All Pages
     */
    public function legalPages()
    {
        $this->pageConfigs['title'] = 'Legal Pages';
        $pages = Page::with('country')->static(2)
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.pages.allpages', [
            'pageConfigs' => $this->pageConfigs,
            'pages' => $pages,
            'islegal'=>true
        ]);
    }

    public function deletePage(Page $page)
    {

        $page->delete();
        $page->sections()->detach();
        return redirect(route('admin.allpages'))->with('success', 'Page deleted successfully.');
    }

    /**
     * Add Section
     */
    public function addSection()
    {
        $this->pageConfigs['title'] = 'Add Section';
        return view('admin.pages.sections.addsection', [
            'pageConfigs' => $this->pageConfigs,
        ]);
    }

    /**
     * Add Section - POST
     * completed: false
     */
    public function addSectionSave(CreateSectionRequest $request)
    {
        // $section = new Section();
        // $section->name = request()->input('name');
        // $section->status = request()->input('status');
        // $section->save();
        $section_data = [
            'name' => request()->input('name'),
            'status' => request()->input('status'),
            'en' => [
                'content' => request()->input('content:en'),
            ],
            'ar' => [
                'content' => request()->input('content:ar'),
            ],
        ];
        Section::create($section_data);

        return redirect(route('admin.addsection'))->with('success', 'Section Created Successfully.');
    }

    /**
     * Edit Section View
     */
    public function editSection(Section $section)
    {
        $this->pageConfigs['title'] = "Edit Section";
        return view('admin.pages.sections.editsection', [
            'pageConfigs' => $this->pageConfigs,
            'section' => $section,
        ]);
    }

    /**
     * Edit Section Save
     */
    public function editSectionSave(EditSectionRequest $request, Section $section)
    {
        $section->update($request->all());

        return redirect(route('admin.editsection', $section->id))->with('success', 'Section Updated successfully.');
    }

    /**
     * All Sections
     */
    public function allSections()
    {
        $this->pageConfigs['title'] = 'All Sections';
        $sections = Section::orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.sections.allsections', [
            'pageConfigs' => $this->pageConfigs,
            'sections' => $sections,
        ]);
    }

    public function deleteSection(Section $section)
    {
        $section->delete();
        return redirect(route('admin.allsections'))->with('success', 'Section deleted successfully.');
    }

    public function allStaticPages()
    {
        $this->pageConfigs['title'] = 'All Static Pages';
        $pages = Page::static(1)
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.allstaticpages', [
            'pageConfigs' => $this->pageConfigs,
            'pages' => $pages,
        ]);
    }

    /**
     * Managers
     */
    public function managers()
    {
        $this->pageConfigs['title'] = 'All Managers';
        $managers = User::type(3)
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.managers.index', [
            'pageConfigs' => $this->pageConfigs,
            'managers' => $managers,
        ]);
    }
    /**
     * Add Manager
     */
    public function addManager()
    {
        $this->pageConfigs['title'] = 'Add Manager';
        return view('admin.pages.managers.addmanager', [
            'pageConfigs' => $this->pageConfigs,
        ]);
    }

    public function addManagerSave(CreateManagerRequest $request)
    {
        $manager_data = [
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => Hash::make(request()->input('password')),
            'phone' => request()->input('phone'),
            'user_type' => 3, // manager
        ];
        $manager = User::create($manager_data);

        if ((request()->input('avatar') !== null) && request()->input('avatar')) {
            $cacheUpload = Admin::getByUuid(request()->input('avatar'));
            $mediaItem = $cacheUpload->getMedia('avatar')->first();
            $mediaItem->copy($manager, 'avatar');
        }

        return redirect(route('admin.addmanager'))->with('success', 'Manager Created Successfully.');
    }

    public function editManager(User $manager)
    {
        // dd($manager->hasMedia('avatar'));
        //dd($manager->getFirstMediaUrl('avatar'));
        $this->pageConfigs['title'] = "Edit Page";
        return view('admin.pages.managers.editmanager', [
            'pageConfigs' => $this->pageConfigs,
            'manager' => $manager,
        ]);
    }

    /**
     * Edit Manager Save
     */
    public function editManagerSave(UpdateManagerRequest $request, User $manager)
    {
        $manager->update($request->all());

        if ((request()->input('avatar') !== null) && request()->input('avatar')) {
            $cacheUpload = Admin::getByUuid(request()->input('avatar'));
            $mediaItem = $cacheUpload->getMedia('avatar')->first();
            $mediaItem->copy($manager, 'avatar');
        }

        return redirect(route('admin.editmanager', $manager->id))->with('success', 'Manager Updated successfully.');
    }

    /**
     * Delete Manager
     */
    public function deleteManager(User $manager)
    {
        $manager->delete();
        return redirect(route('admin.managers'))->with('success', 'Manager deleted successfully.');
    }

    /**
     * Remove Manager Avatar
     */

    public function removeManagerAvatarMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            $model = new User();
            if ($this->removeModelMedia((new User()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Customers
     */

    public function customers()
    {
        $this->pageConfigs['title'] = 'All Customers';
        $customers = User::type(5)
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.customers.index', [
            'pageConfigs' => $this->pageConfigs,
            'customers' => $customers,
        ]);
    }

    /**
     * Drivers
     */

    public function drivers()
    {
        $this->pageConfigs['title'] = 'All Drivers';
        $drivers = User::type(4)
            ->with(['driverprofile', 'driverprofile.area'])
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->paginate($this->maxPageRecords);
        return view('admin.pages.drivers.index', [
            'pageConfigs' => $this->pageConfigs,
            'drivers' => $drivers,
        ]);
    }

    /**
     * Add Driver
     */
    public function addDriver()
    {
        $this->pageConfigs['title'] = 'Add Driver';
        $areas = Front::topAreaList()->pluck('name', 'id');
        return view('admin.pages.drivers.adddriver', [
            'pageConfigs' => $this->pageConfigs,
            'areas' => $areas,
        ]);
    }

    /**
     * Add Driver Save
     */
    public function addDriverSave(CreateDriverRequest $request)
    {
        //dd($request->all());
        $driver = User::create([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => Hash::make(request()->input('password')),
            'phone' => request()->input('phone'),
            'user_type' => 4, // driver
        ]);
        if (!is_null($driver)) {
            $driver->driverprofile()->create([
                'age' => request()->input('age'),
                'area_id' => request()->input('area_id'),
                'vehicle_no' => request()->input('vehicle_no'),
                'gender' => request()->input('gender'),
                'active' => request()->input('active'),
            ]);
        }

        if ((request()->input('avatar') !== null) && request()->input('avatar')) {
            $cacheUpload = Admin::getByUuid(request()->input('avatar'));
            $mediaItem = $cacheUpload->getMedia('avatar')->first();
            $mediaItem->copy($driver, 'avatar');
        }
        if ((request()->input('identity_image') !== null) && request()->input('identity_image')) {
            $cacheUpload = Admin::getByUuid(request()->input('identity_image'));
            $mediaItem = $cacheUpload->getMedia('identity_image')->first();
            $mediaItem->copy($driver, 'identity_image');
        }
        return redirect(route('admin.adddriver'))->with('success', 'Driver Profile Created Successfully.');
    }

    /**
     * Edit Driver View
     */
    public function editDriver(User $driver)
    {
        $this->pageConfigs['title'] = 'Edit Driver';
        $areas = Front::topAreaList()->pluck('name', 'id');
        $areas->prepend('------',0);
        return view('admin.pages.drivers.editdriver', [
            'pageConfigs' => $this->pageConfigs,
            'driver' => $driver,
            'areas' => $areas,
        ]);
    }

    /**
     * Edit Driver Save
     */
    public function editDriverSave(UpdateDriverRequest $request, User $driver)
    {
        $driver->update($request->all());
        $driver->driverprofile()->update([
            'age' => request()->input('age'),
            'area_id' => request()->input('area_id'),
            'vehicle_no' => request()->input('vehicle_no'),
            'gender' => request()->input('gender'),
            'active' => request()->input('active'),
        ]);
        if ((request()->input('avatar') !== null) && request()->input('avatar')) {
            $cacheUpload = Admin::getByUuid(request()->input('avatar'));
            $mediaItem = $cacheUpload->getMedia('avatar')->first();
                $mediaItem->copy($driver, 'avatar');
            
        }
        if ((request()->input('identity_image') !== null) && request()->input('identity_image')) {
            $cacheUpload = Admin::getByUuid(request()->input('identity_image'));
            $mediaItem = $cacheUpload->getMedia('identity_image')->first();
            $mediaItem->copy($driver, 'identity_image');
        }
        if ((request()->input('car_insurance') !== null) && request()->input('car_insurance')) {
            $cacheUpload = Admin::getByUuid(request()->input('car_insurance'));
            $mediaItem = $cacheUpload->getMedia('car_insurance')->first();
            $mediaItem->copy($driver, 'car_insurance');
        }

        return redirect(route('admin.editdriversave', $driver->id))->with('success', 'Driver Updated successfully.');
    }

    /**
     * Delete Driver
     */
    public function deleteDriver(User $driver)
    {
        $driver->delete();
        $driver->driverprofile()->delete();
        return redirect(route('admin.drivers'))->with('success', 'Driver deleted successfully.');
    }

    /**
     * Remove Driver Avatar
     */

    public function removeDriverAvatarMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            $model = new User();
            if ($this->removeModelMedia((new User()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Remove Driver Identity Media
     */

    public function removeDriverIdentityMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            $model = new User();
            if ($this->removeModelMedia((new User()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * --------------------------------
     * Location Module Start
     * --------------------------------
     * Countries
     * States
     * Cities
     * Areas
     */

    /**
     * Countries
     */
    public function countries() 
    {
      $this->pageConfigs['title'] = 'All Countries';
      $countries = Country::orderBy('id', 'DESC')
            ->paginate($this->maxPageRecords);
        return view('admin.pages.countries.index', [
            'pageConfigs' => $this->pageConfigs,
            'countries' => $countries,
        ]);
    }

    /**
     * Add Country
     */
    public function addCountry()
    {
      $this->pageConfigs['title'] = 'Add Country';
        return view('admin.pages.countries.addcountry', [
            'pageConfigs' => $this->pageConfigs,
        ]);  
    }

    /**
     * Add country save
     */

    public function addCountrySave(CreateCountryRequest $request)
    {
      $input = $request->all();
        Country::create([
          'name' => $input['name'],
          'currency' => $input['currency'],
          'language' => $input['language'],
          'phonecode' => $input['phonecode'],
          'active' => $input['active'],
        ]);
      return redirect(route('admin.addcountry'))->with('success', 'Country Created Successfully.');
    }


    /**
     * Edit Country View
     */
    public function editCountry(Country $country)
    {
        $this->pageConfigs['title'] = 'Edit Country';
        return view('admin.pages.countries.editcountry', [
            'pageConfigs' => $this->pageConfigs,
            'country' => $country,
        ]);
    }

    /**
     * Edit country Save
     */
    public function editCountrySave(UpdateCountryRequest $request,Country $country)
    {
      $country->update($request->all());
      return redirect(route('admin.editcountrysave', $country->id))->with('success', 'Country Updated Successfully.');
    }

    /**
     * Delete Country
     */
    public function deleteCountry(Country $country)
    {
        $country->delete();
        return redirect(route('admin.countries'))->with('success', 'Country deleted successfully.');
    }

    
    /**
     * States
     */
    public function states() 
    {
      $this->pageConfigs['title'] = 'All States';
      $states = State::orderBy('id', 'DESC')
            ->paginate($this->maxPageRecords);
        return view('admin.pages.states.index', [
            'pageConfigs' => $this->pageConfigs,
            'states' => $states,
        ]);
    }

    /**
     * Add State
     */
    public function addState()
    {
      $this->pageConfigs['title'] = 'Add State';
        $countries = Country::active()
                  ->select('name','id')
                  ->orderBy('id', 'DESC')
                  ->get();  
        return view('admin.pages.states.addstate', [
            'pageConfigs' => $this->pageConfigs,
            'countries' => $countries->pluck('name', 'id'),
        ]);  
    }

    /**
     * Add state save
     */

    public function addStateSave(CreateStateRequest $request)
    {
        State::create($request->all());
      return redirect(route('admin.addstate'))->with('success', 'State Created Successfully.');
    }


    /**
     * Edit State View
     */
    public function editState(State $state)
    {
        $this->pageConfigs['title'] = 'Edit State';
        $countries = Country::active()
                  ->select('name','id')
                  ->orderBy('id', 'DESC')
                  ->get(); 
        return view('admin.pages.states.editstate', [
            'pageConfigs' => $this->pageConfigs,
            'state' => $state,
            'countries' => $countries->pluck('name', 'id'),
        ]);
    }

    /**
     * Edit state Save
     */
    public function editStateSave(UpdateStateRequest $request,State $state)
    {
      $state->update([
        'name' => $request->input('name'),
        'active' => (($request->input('active')) ? 1 : 0),
      ]);
      return redirect(route('admin.editstatesave', $state->id))->with('success', 'State Updated Successfully.');
    }

    /**
     * Delete State
     */
    public function deleteState(State $state)
    {
        $state->delete();
        return redirect(route('admin.states'))->with('success', 'State deleted successfully.');
    }
    
    /**
     * Cities
     */
    public function cities() 
    {
      $this->pageConfigs['title'] = 'All Cities';
      $cities = City::orderBy('id', 'DESC')
            ->paginate($this->maxPageRecords);
        return view('admin.pages.cities.index', [
            'pageConfigs' => $this->pageConfigs,
            'cities' => $cities,
        ]);
    }

    /**
     * Add City
     */
    public function addCity()
    {
      $this->pageConfigs['title'] = 'Add City';
      $states = State::active()
          ->select('name','id')
          ->orderBy('id', 'DESC')
          ->get(); 
        return view('admin.pages.cities.addcity', [
            'pageConfigs' => $this->pageConfigs,
            'states' => $states->pluck('name','id'),
        ]);  
    }

    /**
     * Add city save
     */

    public function addCitySave(CreateCityRequest $request)
    {
        City::create($request->all());
      return redirect(route('admin.addcity'))->with('success', 'City Created Successfully.');
    }


    /**
     * Edit City View
     */
    public function editCity(City $city)
    {
        $this->pageConfigs['title'] = 'Edit City';
        $states = State::active()
          ->select('name','id')
          ->orderBy('id', 'DESC')
          ->get(); 
        return view('admin.pages.cities.editcity', [
            'pageConfigs' => $this->pageConfigs,
            'city' => $city,
            'states' => $states->pluck('name','id'),
        ]);
    }

    /**
     * Edit city Save
     */
    public function editCitySave(UpdateCityRequest $request,City $city)
    {
      $city->update([
        'name' => $request->input('name'),
        'active' => (($request->input('active')) ? 1 : 0),
      ]);
      return redirect(route('admin.editcity', $city->id))->with('success', 'City Updated Successfully.');
    }

    /**
     * Delete City
     */
    public function deleteCity(City $city)
    {
        $city->delete();
        return redirect(route('admin.cities'))->with('success', 'City deleted successfully.');
    }

    /**
     * Areas
     */
    public function areas() 
    {
      $this->pageConfigs['title'] = 'All Areas';
      $areas = Area::with(['city' => function ($q) {
                  $q->select('id', 'name');
              }])
            ->orderBy('id', 'DESC')
            ->paginate($this->maxPageRecords);
        return view('admin.pages.areas.index', [
            'pageConfigs' => $this->pageConfigs,
            'areas' => $areas,
        ]);
    }

    /**
     * Add Area
     */
    public function addArea()
    {
      $this->pageConfigs['title'] = 'Add Area';
        $cities = City::active()
          ->select('name','id')
          ->orderBy('id', 'DESC')
          ->get(); 
        return view('admin.pages.areas.addarea', [
            'pageConfigs' => $this->pageConfigs,
            'cities' => $cities->pluck('name','id'),
        ]);  
    }

    /**
     * Add area save
     */

    public function addAreaSave(CreateAreaRequest $request)
    {
      $input = $request->all();
        Area::create([
          'city_id' => $input['city_id'],
          'name' => $input['name'],
          'active' => $input['active'],
        ]);
      return redirect(route('admin.addarea'))->with('success', 'Area Created Successfully.');
    }


    /**
     * Edit Area View
     */
    public function editArea(Area $area)
    {
        $this->pageConfigs['title'] = 'Edit Area';
        $cities = City::active()
          ->select('name','id')
          ->orderBy('id', 'DESC')
          ->get(); 
        return view('admin.pages.areas.editarea', [
            'pageConfigs' => $this->pageConfigs,
            'area' => $area,
            'cities' => $cities->pluck('name','id'),
        ]);
    }

    /**
     * Edit area Save
     */
    public function editAreaSave(UpdateAreaRequest $request,Area $area)
    {
      $area->update([
        'name' => $request->input('name'),
        'active' => (($request->input('active')) ? 1 : 0),
      ]);
      return redirect(route('admin.editareasave', $area->id))->with('success', 'Area Updated Successfully.');
    }

    /**
     * Delete Area
     */
    public function deleteArea(Area $area)
    {
        $area->delete();
        return redirect(route('admin.areas'))->with('success', 'Area deleted successfully.');
    }


/**
 * ---------------------------------
 * Location Module End
 * ---------------------------------
 */


    /**
     * Area Managers
     */
    public function areaManagers()
    {
        $this->pageConfigs['title'] = 'Area Managers';
        $areamanagers = AreaManager::select('*')
            ->with(['areas' => function ($q) {
                $q->select('id', 'name');
            },
                'user' => function ($q) {
                    $q->select('id', 'name');
                }])
            ->orderBy('id', 'DESC')
            ->paginate($this->maxPageRecords);
        return view('admin.pages.areamanagers.index', [
            'pageConfigs' => $this->pageConfigs,
            'areamanagers' => $areamanagers,
        ]);
    }

    public function addAreaManager()
    {
        $this->pageConfigs['title'] = 'Add Area Manager';
        $areas = Area::select('name', 'id')
            ->where('active', 1)
            ->whereNOTIn('id', function ($q) {
                $q->select('area_id')->from('area_managers');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $managers = User::select('name', 'id')
            ->type(3)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.pages.areamanagers.addareamanager', [
            'pageConfigs' => $this->pageConfigs,
            'areas' => $areas->pluck('name','id'),
            'managers' => $managers->pluck('name','id'),
        ]);
    }

    public function addAreaManagerSave(Request $request)
    {
      $input = $request->all();
      if (isset($input['area_id']) && $input['area_id'] && isset($input['user_id']) && $input['user_id'])
      {
        AreaManager::create([
          'area_id' => $input['area_id'],
          'user_id' => $input['user_id'],
        ]);
      }
      return redirect(route('admin.addareamanager'))->with('success', 'Area Manager Created Successfully.');
    }

    public function deleteAreaManager(AreaManager $am)
    {
        $am->delete();
        return redirect(route('admin.areamanagers'))->with('success', 'Area Manager deleted successfully.');
    }


    /**
     * Remove Model Media
     */
    private function removeModelMedia($model, $id, $collection)
    {
        if ($m = $model->find($id)) {

            if ($m->hasMedia($collection)) {
                $m->getFirstMedia($collection)->delete();
                return true;
            }
            return true;
        }
        return false;
    }

    public function frontSettings()
    {
        $this->pageConfigs['title'] = 'Front Settings';
        $front_logo = Upload::where('uuid', setting('front_logo'))->first();
        $admin_logo = Upload::where('uuid', setting('admin_logo'))->first();
        $icon_logo = Upload::where('uuid', setting('icon_logo'))->first();
       // dd($front_logo->hasMedia('front_logo'));
       // dd($front_logo->getFirstMediaUrl('front_logo','thumb'));
        return view('admin.pages.settings.frontsettings', [
            'pageConfigs' => $this->pageConfigs,
            'front_logo' => $front_logo,
            'admin_logo' => $admin_logo,
            'icon_logo' => $icon_logo,
        ]);
    }

    public function frontSettingsSave(Request $request)
    {
        $input = $request->except(['_method', '_token']);
        if (empty($input['front_logo'])) {
            unset($input['front_logo']);
        }
        if (empty($input['admin_logo'])) {
            unset($input['admin_logo']);
        }
        if (empty($input['icon_logo'])) {
            unset($input['icon_logo']);
        }
        setting($input)->save();
        return redirect(route('admin.frontsettings'))->with('success', 'Settings saved successfully.');
    }

    public function removeMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            if (Admin::removeModelMedia((new Upload()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }

    public function onlinePayments()
    {
        $this->pageConfigs['title'] = 'Online Payments';

        $payments = \App\OnlinePayment::select('*') // will optimize
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.onlinepayment.index', [
            'pageConfigs' => $this->pageConfigs,
            'onlinepayments' => $payments,
        ]);
    }
}
