@extends('pages.driver.driverlayout')
@section('driverpage')
@include('pages.driver.navbar')
<div class="roms--orders">
    <h4 class="mb-5">My Ratings</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive roms--myorders">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Ratings</th>
                            <th>Merchant Name</th>
                            <th>Order Total</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 9; $i++) <tr>
                            <td>#1231213</td>
                            <td>
                                <select class="ps-rating" data-read-only="true">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </td>
                            <td>Dominos</td>
                            <td>$240</td>
                            <td>#123 abc city state Country 120120</td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
