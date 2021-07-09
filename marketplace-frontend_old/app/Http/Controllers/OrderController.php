<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $this->pageConfigs['title'] = 'All Orders';

        $orders = Order::with([
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
            ->paginate($this->maxPageRecords);
        return view('admin.pages.order.index', [
            'pageConfigs' => $this->pageConfigs,
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
      $order->load([
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
            'orderitems' => function ($q) {
                $q->select('id','order_id', 'name','quantity','price');
            },
        ]);
        $this->pageConfigs['title'] = 'All Orders';
        return view('admin.pages.order.show', [
            'pageConfigs' => $this->pageConfigs,
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
