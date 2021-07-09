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
use App\Page;
use App\Section;
use App\User;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;

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
        return view('admin.pages.pages.addpage', [
            'pageConfigs' => $this->pageConfigs,
            'sections' => $sections,
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
        ];
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
        return view('admin.pages.pages.editpage', [
            'pageConfigs' => $this->pageConfigs,
            'page' => $page,
            'sections' => $sections,
            'active' => $active,
        ]);
    }

    /**
     * Edit Page Save
     */
    public function editPageSave(EditPageRequest $request, Page $page)
    {
        $page->update($request->all());
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
     * Areas
     */
    public function areas() 
    {
      $this->pageConfigs['title'] = 'All Areas';
      $areas = Area::orderBy('id', 'DESC')
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
        return view('admin.pages.areas.addarea', [
            'pageConfigs' => $this->pageConfigs,
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
        return view('admin.pages.areas.editarea', [
            'pageConfigs' => $this->pageConfigs,
            'area' => $area,
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
      return redirect(route('admin.editareasave', $area->id))->with('success', 'Area Created Successfully.');
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
