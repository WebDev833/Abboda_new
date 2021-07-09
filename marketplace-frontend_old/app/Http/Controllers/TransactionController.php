<?php

namespace App\Http\Controllers;

use App\SystemPays;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateTransactionRequest;
use App\Http\Requests\Admin\UpdateTransactionRequest;

class TransactionController extends Controller
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
        $this->pageConfigs['title'] = 'All Transactions';

        $transactions = SystemPays::select('*') // will optimize
            ->with([
              'sender'=>function($q){
                $q->select('id','name');
              },
              'receiver'=>function($q){
                $q->select('id','name');
              },
            ])
            ->orderBy('id', 'DESC')            
            ->paginate($this->maxPageRecords);
        return view('admin.pages.transaction.index', [
            'pageConfigs' => $this->pageConfigs,
            'transactions' => $transactions,
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
        $users = User::whereIn('user_type',[2,3])
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.transaction.create', [
            'pageConfigs' => $this->pageConfigs,
            'users' => $users->pluck('name','id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request)
    {
      $request->merge([
        'paid' => $request->has('paid') ? true : false,
        'received' => $request->has('received') ? true : false,
      ]);
      SystemPays::create($request->all());
      return redirect(route('admin.transactions.create'))->with('success', 'Transaction Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SystemPays  $systemPays
     * @return \Illuminate\Http\Response
     */
    public function show(SystemPays $systemPays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SystemPays  $systemPays
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemPays $transaction)
    {
        $this->pageConfigs['title'] = 'Add Workday';
        $users = User::whereIn('user_type',[2,3])
        ->select('name','id')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.transaction.edit', [
            'pageConfigs' => $this->pageConfigs,
            'users' => $users->pluck('name','id'),
            'transaction' => $transaction
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SystemPays  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemPays $transaction)
    {
      $request->merge([
        'paid' => $request->has('paid') ? true : false,
        'received' => $request->has('received') ? true : false,
      ]);
      $transaction->update($request->all());
      return redirect(route('admin.transactions.edit',$transaction->id))->with('success', 'Transaction Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SystemPays  $systemPays
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemPays $transaction)
    {
        $transaction->delete();
        return redirect(route('admin.transactions.index'))->with('success', 'Transaction deleted successfully.');
    }
}
