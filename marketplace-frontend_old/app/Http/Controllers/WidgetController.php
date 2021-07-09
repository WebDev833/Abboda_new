<?php

namespace App\Http\Controllers;

use App\Widget;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateWidgetRequest;
use App\Http\Requests\Admin\UpdateWidgetRequest;

class WidgetController extends Controller
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
        $this->pageConfigs['title'] = 'All Widgets';

        $widgets = Widget::select('*') // will optimize
            ->orderBy('id', 'DESC')        
            ->paginate($this->maxPageRecords);
        return view('admin.pages.widget.index', [
            'pageConfigs' => $this->pageConfigs,
            'widgets' => $widgets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageConfigs['title'] = 'Add Widget';
        return view('admin.pages.widget.create', [
            'pageConfigs' => $this->pageConfigs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $widget_data = [
            'unique_key' => request()->input('unique_key'),
            'status' => request()->input('status'),
            'body' => [
                'en' => request()->input('body:en'),
                'ar' => request()->input('body:ar'),
            ]
        ];
        Widget::create($widget_data);
        return redirect(route('admin.widgets.create'))->with('success', 'Widget Created Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function show(Widget $widget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function edit(Widget $widget)
    {
        $this->pageConfigs['title'] = 'Edit Widget';
        return view('admin.pages.widget.edit', [
            'pageConfigs' => $this->pageConfigs,
            'widget' => $widget
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Widget $widget)
    {
      $widget_data = [
            'status' => request()->input('status'),
            'body' => [
                'en' => request()->input('body:en'),
                'ar' => request()->input('body:ar'),
            ]
        ];
      $widget->update($widget_data);
      return redirect(route('admin.widgets.edit',$widget->id))->with('success', 'Widget Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Widget $widget)
    {
        $widget->delete();
        return redirect(route('admin.widgets.index'))->with('success', 'Widget deleted successfully.'); 
    }
}
