<?php

namespace App\Http\Controllers;

use App\Helpers\Front;
use App\Models\Company;
use Exception;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CompanyController extends Controller
{
  /**
   * Get Products from a collection
   * 
   * @param Array $products
   * 
   * @return array
   */
    private function getProducts($products = [])
    {
        $proArray = [];
        foreach ($products as $product) {
            $proArray[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image' => Front::myMediaUrl($product, 'product_image', 'product'),
            ];
        }
        return $proArray;
    }

    /**
     * Store method - Show store
     * 
     * @param Request $request
     * @param String $slug
     * 
     * @return mixed
     */

    public function show(Request $request, $slug = null)
    {
        if ($slug == null || !$request->is('store/*')) {
            // null url or not store page. 
            return redirect(route('home'));
        }
        try
        {
            $company = Company::where(['slug'=> $slug,'active'=>1])->firstOrFail();
            $categories = $company->categories()->where([
                'active' => 1,
            ])->with([
                'products' => function ($product) {
                    $product->where(['active' => 1, 'in_stock' => 1])->with('media');
                    //
                    // optimize the query by specific column...
                    // $product->select(['id','name','description','price']);
                },
                'media',
            ])->select('id', 'name')->get();
            //company info
            $companyArray = [
                'id' => $company->id,
                'acceptingOrders' => Front::workingCompany($company->id),
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'image' => Front::myMediaUrl($company, 'company_image', 'logo'),
            ];
            // get workdays.
            $workdays = $company->workdays()->select('id', 'day', 'open_time', 'close_time')->get();
            // categories
            $ncats = new Collection();
            foreach ($categories as $category) {
                $ncats->push([
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => Front::myMediaUrl($category, 'category_image'),
                    'products' => $this->getProducts($category->products),
                ]);
            }

            // Complete company
            $store = [
                'company' => $companyArray, // already an array.
                'categories' => $ncats->toArray(),
                'workdays' => $workdays->toArray(),
            ];

            // dd($store);

            $pageConfigs = [
                'newsletter' => false,
                'breadcrumb' => true,
                'title' => $company->name, //store page
            ];
            return view('pages.store', [
                'pageConfigs' => $pageConfigs,
                'store' => $store,
            ]);

        } catch (Exception $e) {
            //  Marketing Mind :)
            // We can show interactive message here -> like register or refer a restaturant..... like that..
            // For now lets redirect to home..
            return redirect(route('home'));
        }

    }

    /**
     * Search Method - Search based on keyword
     * 
     * @param String $keyword
     * @return mixed
     */
    public function search(Request $request)
    {
      //dd([request()->input('keyword')]);
      if(request()->input('keyword') == null)
      {
        return redirect(route('home'));
      }
      $keyword = request()->input('keyword');
      // tag-matched-previously : get tag match more perfect search. 

      /**
       * we have location - Do some hack here :)
       */
      if(Session::has('location'))
      {

      }

      $compQuery = Company::where([
            'active' => 1,
        ])
        ->whereLike(['name','address','products.name','categories.name'],$keyword)
        ->with('media')->get();
        //dd($compQuery);
        $companies = new collection();

        foreach ($compQuery as $company) {
            $companies->push([
                'id' => $company->id,
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'image' => Front::myMediaUrl($company, 'company_image', 'banner'),
            ]);
        }
       // dd($companies);

        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Search Page',
        ];
        return view('pages.search-results', [
            'pageConfigs' => $pageConfigs,
            'companies' => $companies->toArray(),
        ]);

    }
}
