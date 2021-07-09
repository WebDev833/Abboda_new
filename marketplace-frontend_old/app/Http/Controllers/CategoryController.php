<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;

use Illuminate\Http\Request;
use App\Helpers\Admin;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
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
        $this->pageConfigs['title'] = 'All Categories';

        $categories = Category::select('*') // will optimize
            ->with(['company'=>function($q){
              $q->select('id','name');
            }])
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.category.index', [
            'pageConfigs' => $this->pageConfigs,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageConfigs['title'] = 'Add Catgory';
        $merchants = Company::active()
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.category.addcategory', [
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
    public function store(CreateCategoryRequest $request)
    {
        $category_data = [
            'company_id' => request()->input('company_id'),
            'name' => request()->input('name'),
            'active' => (request()->input('active')) ? 1 : 0,
        ];
        $category = Category::create($category_data);

        if ((request()->input('category_image') !== null) && request()->input('category_image')) {
            $cacheUpload = Admin::getByUuid(request()->input('category_image'));
            $mediaItem = $cacheUpload->getMedia('category_image')->first();
            $mediaItem->copy($category, 'category_image');
        }

        return redirect(route('admin.addcategory'))->with('success', 'Category Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->pageConfigs['title'] = 'Edit Catgory';
        $merchants = Company::active()
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.category.editcategory', [
            'pageConfigs' => $this->pageConfigs,
            'category' => $category,
            'merchants' => $merchants->pluck('name','id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category_data = [
            'company_id' => request()->input('company_id'),
            'name' => request()->input('name'),
            'active' => (request()->input('active')) ? 1 : 0,
        ];
        $category->update($category_data);

        if ((request()->input('category_image') !== null) && request()->input('category_image')) {
            $cacheUpload = Admin::getByUuid(request()->input('category_image'));
            $mediaItem = $cacheUpload->getMedia('category_image')->first();
            $mediaItem->copy($category, 'category_image');
        }

        return redirect(route('admin.editcategory',$category->id))->with('success', 'Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('admin.categories'))->with('success', 'Category deleted successfully.');
    }

    /**
     * Remove Category Image 
     */
    public function removeCategoryImageMedia(Request $request)
    {
        $input = $request->all();
        if (isset($input['id']) && $input['id'] && isset($input['collection']) && $input['collection']) {
            if (Admin::removeModelMedia((new Category()), $input['id'], $input['collection'])) {
                return true;
            }
        }
        return false;
    }

}
