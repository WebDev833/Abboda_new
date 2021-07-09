@extends('pages.driver.driverlayout')
@section('driverpage')
@include('pages.driver.navbar')
    <div class="roms--orders">
        <h4 class="mb-5">My Earnings</h4>
        <div class="row">
        <div class="col-md-12">
        <div class="table-responsive roms--myorders">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                  @if ($orders->count())
                    @foreach ($orders as $order)
                      <tr>
                          <td>{{ $order->unique_order_id }}</td>
                          <td>{{ $order->orderstatus->name }}</td>
                          @if (is_null($order->settlement) || ($order->settlement->received == 0))
                          <td>Not Paid Yet</td>
                          @else
                          <td>{{ 'Paid' }}</td>
                          @endif
                          <td>{{ romsProPrice($order->payment->driver_amount,false) }}</td>
                      </tr>
                    @endforeach
                  @else
                      <tr class="no-row-exist"><td colspan="6" class="p-4 text-center">No earnings yet..!!!</td></tr>
                  @endif
                </tbody>
            </table>
        </div>
        </div>
        </div>

</div>
@endsection
