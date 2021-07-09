@extends('pages.manager.managerlayout')
@section('managerpage')
@include('pages.manager.navbar')
    <div class="roms--orders">
        @include('panels.success')
        @include('panels.errors')
        <h4 class="mb-5">My Transactions</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="float-right"><a href="{{route('manager.createTransaction')}}" class="ps-btn ps-btn--sm mb-4">+ Create Transaction</a></div>
          </div>
        </div>
        <div class="row">
        <div class="col-md-12">
        <div class="table-responsive roms--myorders">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th># ID</th>
                        <th>Driver</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Received</th>
                        <th>Updations</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if ($transactions->count())
                    @foreach ($transactions as $transaction)
                      <tr>
                          <td>#{{ $transaction->id }}</td>
                          <td>{{ $transaction->receiver->name }}</td>
                          <td>{{ romsProPrice($transaction->amount,false) }}</td>
                          <td>{!! romsBoolColumn($transaction,'paid') !!}</td>
                          <td>{!! romsBoolColumn($transaction,'received') !!}</td>
                          <td>{!! romsDateColumn($transaction,'updated_at') !!}</td>
                          <td><a href="{{route('manager.editTransaction',['id'=>$transaction->id])}}" class="roms--orderdetails-link"><i class="fa fa-pencil"></i> Edit</a></td>
                      </tr>
                    @endforeach
                  @else
                      <tr class="no-row-exist"><td colspan="7" class="p-4 text-center">No Transaction data yet..!!!</td></tr>
                  @endif
                </tbody>
            </table>
              <div class="mt-3 pt-30 ps-pagination roms--front-pagination">
                  {{ $transactions->links() }}
              </div>
        </div>
        </div>
        </div>

</div>
@endsection
