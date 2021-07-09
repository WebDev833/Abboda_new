<?php

namespace App\Http\Controllers;

use App\Helpers\Admin;
use App\Workday;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateWorkdayRequest;
use App\Http\Requests\Admin\UpdateWorkdayRequest;

class WorkdayController extends Controller
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
        $this->pageConfigs['title'] = 'All Workdays';

        $workdays = Workday::select('*') // will optimize
            ->with(['company'=>function($q){
              $q->select('id','name');
            }])
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.workday.index', [
            'pageConfigs' => $this->pageConfigs,
            'workdays' => $workdays,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageConfigs['title'] = 'Add Workday';
        $merchants = Company::active()
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        $timeArray = Admin::timeArray();
        return view('admin.pages.workday.addworkday', [
            'pageConfigs' => $this->pageConfigs,
            'timeArray' => $timeArray,
            'merchants' => $merchants->pluck('name','id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkdayRequest $request)
    {
        $workday = Workday::create($request->all());

        return redirect(route('admin.addworkday'))->with('success', 'Workday Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Workday  $workday
     * @return \Illuminate\Http\Response
     */
    public function show(Workday $workday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workday  $workday
     * @return \Illuminate\Http\Response
     */
    public function edit(Workday $workday)
    {
        $this->pageConfigs['title'] = 'Edit Workday';
        $merchants = Company::active()
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        $timeArray = Admin::timeArray();
        return view('admin.pages.workday.editworkday', [
            'pageConfigs' => $this->pageConfigs,
            'workday' => $workday,
            'timeArray' => $timeArray,
            'merchants' => $merchants->pluck('name','id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workday  $workday
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkdayRequest $request, Workday $workday)
    {
        $workday->update($request->all());
        return redirect(route('admin.editworkday',$workday->id))->with('success', 'Workday Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workday  $workday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workday $workday)
    {
        $workday->delete();
        return redirect(route('admin.workdays'))->with('success', 'Workdays deleted successfully.');
    }
}
