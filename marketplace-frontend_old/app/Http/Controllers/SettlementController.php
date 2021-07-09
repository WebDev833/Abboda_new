<?php

namespace App\Http\Controllers;

use App\Settlement;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateSettlementRequest;
use App\Http\Requests\Admin\UpdateSettlementRequest;
use Auth;

class SettlementController extends Controller
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
        $this->pageConfigs['title'] = 'All Settlements';

        $settlements = Settlement::select('*') // will optimize
            ->with([
              'settler'=>function($q){
                $q->select('id','name');
              }
             ])
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.settlement.index', [
            'pageConfigs' => $this->pageConfigs,
            'settlements' => $settlements,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageConfigs['title'] = 'Add Settlement';
        $orders = Order::select('id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.settlement.create', [
            'pageConfigs' => $this->pageConfigs,
            'orders' => $orders->pluck('id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSettlementRequest $request)
    {
      $request->merge([
        'settler_id' => $request->has('settler_id') ? $request->has('settler_id') : Auth::user()->id,
        'received' => $request->has('received') ? true : false,
      ]);
      //dd($request->all());
      Settlement::create($request->all());
      return redirect(route('admin.settlements.create'))->with('success', 'Settlement Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function show(Settlement $settlement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function edit(Settlement $settlement)
    {
        $this->pageConfigs['title'] = 'Edit Settlement';
        $orders = Order::select('id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.settlement.edit', [
            'pageConfigs' => $this->pageConfigs,
            'orders' => $orders->pluck('id'),
            'settlement' => $settlement
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettlementRequest $request, Settlement $settlement)
    {
      $request->merge([
        'received' => $request->has('received') ? true : false,
      ]);
      $settlement->update($request->all());
      return redirect(route('admin.settlements.edit',$settlement->id))->with('success', 'Settlement Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settlement $settlement)
    {
        $settlement->delete();
        return redirect(route('admin.settlements.index'))->with('success', 'Settlement deleted successfully.');
    }
}
