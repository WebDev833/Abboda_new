<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Helpers\Admin;
use App\Helpers\Front;
use App\CompanyType;

use App\Http\Requests\Admin\CreateMerchantRequest;
use App\Http\Requests\Admin\UpdateMerchantRequest;

class MerchantController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->pageConfigs['title'] = 'All Merchants';

        $merchants = Company::select('*') // will optimize
            ->with(['area'=>function($q){
              $q->select('id','name');
            }])
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.merchant.index', [
            'pageConfigs' => $this->pageConfigs,
            'merchants' => $merchants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageConfigs['title'] = 'Add Merchant';
        $companytypes = CompanyType::active()
                  ->select('name','id')
                  ->orderBy('id', 'DESC')
                  ->get();                  
        $areas = Front::topAreaList()->pluck('name', 'id');
        return view('admin.pages.merchant.addmerchant', [
            'pageConfigs' => $this->pageConfigs,
            'companytypes' => $companytypes->pluck('name', 'id'),
            'areas' => $areas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMerchantRequest $request)
    {
        $company = (new Company())->fill($request->all());
        $company->save();
        if ((request()->input('merchant_image') !== null) && request()->input('merchant_image')) {
            $cacheUpload = Admin::getByUuid(request()->input('merchant_image'));
            $mediaItem = $cacheUpload->getMedia('merchant_image')->first();
            $mediaItem->copy($company, 'merchant_image');
        }

        return redirect(route('admin.addmerchant'))->with('success', 'Merchant Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $merchant)
    {
        $this->pageConfigs['title'] = 'Edit Merchant';
        $companytypes = CompanyType::active()
                  ->select('name','id')
                  ->orderBy('id', 'DESC')
                  ->get();                  
        $areas = Front::topAreaList()->pluck('name', 'id');
        return view('admin.pages.merchant.editmerchant', [
            'pageConfigs' => $this->pageConfigs,
            'companytypes' => $companytypes->pluck('name', 'id'),
            'areas' => $areas,
            'merchant' => $merchant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMerchantRequest $request, Company $merchant)
    {
      $request->merge([
        'active' => $request->has('active') ? true : false,
        'catalog_enabled' => $request->has('catalog_enabled') ? true : false,
      ]);
      $merchant->update($request->all());
      if ((request()->input('merchant_image') !== null) && request()->input('merchant_image')) {
          $cacheUpload = Admin::getByUuid(request()->input('merchant_image'));
          $mediaItem = $cacheUpload->getMedia('merchant_image')->first();
          $mediaItem->copy($merchant, 'merchant_image');
      }
      return redirect(route('admin.editmerchant',['merchant'=> $merchant->id]))->with('success', 'Merchant Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect(route('admin.merchants'))->with('success', 'Merchant deleted successfully.');
    }

    /**
     * Remove Merchant Image 
     */
    public function removeMerchantImageMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            if (Admin::removeModelMedia((new Company()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * AJAX Functions
     * COMPANY categories
     */
    public function categories(Request $request)
    {
      if(!is_null($request->input('id')))
      {
          $collecion = \App\Models\Category::where('company_id',$request->input('id'))
          ->orderBy('id','DESC')
          ->select('id','name')
          ->get();
       return json_encode(['status'=>true,'data'=>$collecion]);
      }
      return json_encode(['status'=>false,'message'=>'Required Parameters missing.']);
    }
}
