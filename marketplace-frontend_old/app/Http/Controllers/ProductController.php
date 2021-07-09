<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Helpers\Admin;

class ProductController extends Controller
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
        $this->pageConfigs['title'] = 'All Products';

        $products = Product::select('*') // will optimize
            ->with(['company'=>function($q){
                $q->select('id','name');
              },
              'category'=>function($q)
              {
                $q->select('id','name');
              }
            ])
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.product.index', [
            'pageConfigs' => $this->pageConfigs,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageConfigs['title'] = 'Add Product';
        $merchants = Company::active()
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.product.addproduct', [
            'pageConfigs' => $this->pageConfigs,
            'merchants' => $merchants->pluck('name','id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
      $request->merge([
        'active' => $request->has('active') ? true : false,
        'in_stock' => $request->has('in_stock') ? true : false,
      ]);

      $product = (new Product())->fill($request->all());
      $product->save();
      if ((request()->input('product_image') !== null) && request()->input('product_image')) {
          $cacheUpload = Admin::getByUuid(request()->input('product_image'));
          $mediaItem = $cacheUpload->getMedia('product_image')->first();
          $mediaItem->copy($product, 'product_image');
      }

      return redirect(route('admin.addproduct'))->with('success', 'Product added Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->pageConfigs['title'] = 'Edit Product';
        $merchants = Company::active()
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.product.editproduct', [
            'pageConfigs' => $this->pageConfigs,
            'merchants' => $merchants->pluck('name','id'),
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
      $request->merge([
        'active' => $request->has('active') ? true : false,
        'in_stock' => $request->has('in_stock') ? true : false,
      ]);

      $product->update($request->all());
      if ((request()->input('product_image') !== null) && request()->input('product_image')) {
          $cacheUpload = Admin::getByUuid(request()->input('product_image'));
          $mediaItem = $cacheUpload->getMedia('product_image')->first();
          $mediaItem->copy($product, 'product_image');
      }

      return redirect(route('admin.editproduct',$product->id))->with('success', 'Product Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('admin.products'))->with('success', 'Product deleted successfully.');
    }

    /**
     * Remove Product Image 
     */
    public function removeProductImageMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            if (Admin::removeModelMedia((new Product()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }
}
