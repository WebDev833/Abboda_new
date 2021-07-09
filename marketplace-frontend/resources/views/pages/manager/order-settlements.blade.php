@extends('pages.manager.managerlayout')
@section('managerpage')
@include('pages.manager.navbar')
    <div class="roms--orders">
        @include('panels.success')
        @include('panels.errors')
        <h4 class="mb-5">Order Settlements</h4>
        <div class="row">
        <div class="col-md-12">
        <div class="table-responsive roms--myorders">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th># ID</th>
                        <th>Order Total</th>
                        <th>Receive Amount</th>
                        <th>Pay Amount</th>
                        <th>Settled</th>
                        <th>Order Date</th>
                        <th>Settle Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if ($orders->count())
                    @foreach ($orders as $order)
                      <tr>
                          <td>{{ $order->unique_order_id }}</td>
                          <td>{{ romsProPrice($order->total,false) }}</td>
                          @if ($order->payment->payment_type == 1)
                              <td>{{ romsProPrice($order->payment->system_amount,false) }}</td>
                          @else
                             <td>{{ romsProPrice(0,false) }}</td> 
                          @endif
                          @if ($order->payment->payment_type == 2)
                              <td>{{ romsProPrice($order->payment->driver_amount,false) }}</td>
                          @else
                             <td>{{ romsProPrice(0,false) }}</td> 
                          @endif
                          <td>{!! romsBoolColumn($order->settlement,'received') !!}</td>
                          <td>{!! romsDateColumn($order,'created_at') !!}</td>
                          @if ($order->settlement->received)
                          <td>{!! romsDateColumn($order->settlement,'updated_at') !!}</td>                              
                          @else
                              <td>-</td>
                          @endif
                          
                            @if (!$order->settlement->received)
                            <td>
                              <a href="{{route('manager.completeSettlement',['id'=>$order->id])}}" class="roms--orderdetails-link"><i class="fa fa-check"></i> Mark as Settlled</a>
                            </td>
                            @else
                                <td>-</td>                                
                            @endif
                            
                      </tr>
                    @endforeach
                  @else
                      <tr class="no-row-exist"><td colspan="8" class="p-4 text-center">No settlement data yet..!!!</td></tr>
                  @endif
                </tbody>
            </table>
              <div class="mt-3 pt-30 ps-pagination roms--front-pagination">
                  {{ $orders->links() }}
              </div>
        </div>
        </div>
        </div>

</div>
@endsection
