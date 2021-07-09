@extends('pages.user.userlayout')
@section('userpage')


    <div class="roms--orders">
        <div class="row mb-5 mt-5">
            <div class="address-btn col-md-12">
                <h6 class="pull-left onlydesktop">Addresses</h6>
                <div class="add-address-content">
                <button type="button" class="edit-profile-btn pull-right"   data-toggle="modal" data-target="#addAddressModel" onclick="loadModel()">ADD NEW ADDRESS</button>
                </div>
            </div>
        </div>
        
        <div class="user-address">
        @if ($addresses->count())
                    @foreach ($addresses as $address)
        <div class="main-content-profile addresses">
    <div class="icon-image-profile">
  <i class="icon-profile-dial"> <img src="{{asset('images/location-icon.png')}}"></i> 
  </div>
<div class="text-icon-profile">
  
    <h6 class="text-subtitle color-secondary">{{ $address->label_name }}</h6>
    <div class="address-detail">
    <p class="text-body2 color-medium">{{ $address->map_address }}</p>
    </div>
</div>
</div>
<hr class="notfordesktop">
@endforeach
                  @else
                  <div class="main-content-profile addresses">
                     <h6 class="text-center">No Address Yet</h6>
                  </div>
                  @endif

        </div>
       {{-- <div class="row">
        <div class="col-md-12">
        <div class="table-responsive roms--myorders">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Address</th>
                        <th>Street</th>
                        <th>Floor/Unit</th>
                        <th>Notes</th>
                        <th>Default</th>
                    </tr>
                </thead>
                <tbody>
                  @if ($addresses->count())
                    @foreach ($addresses as $address)
                      <tr>
                          <td>{{ $address->label_name }}</td>
                          <td>{{ $address->map_address }}</td> 
                          <td>{{ $address->street }}</td>
                          <td>{{ $address->floor_unit }}</td>
                          <td>{{ $address->notes }}</td>
                          <td> <input type="radio" name="active" onclick="makeDefaultAddress({{ $address->id }})" @if($address->active) checked @endif ></td>
                    </tr>
                    @endforeach
                  @else
                      <tr class="no-row-exist"><td colspan="6" class="p-4 text-center">No Address Yet..!!!</td></tr>
                  @endif
                </tbody>
            </table>
        </div>
        </div>
        </div>--}}

</div>


<!-- Modal -->
<div class="modal fade" id="addAddressModel" tabindex="-1" role="dialog" aria-labelledby="addAddressModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title color-secondary" >Add New Address</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"  class="close-popup">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="model_body_ajax">
        Please wait....
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('page-scripts')

<script>

function loadModel()
{
  $.get('{{route("addAddressApi")}}',{dup:true},function(data){
  $("#model_body_ajax").html(data);
});
}

function makeDefaultAddress(id)
{
    $.post("{{route('user.addressBookupdateStatus')}}",{_token:'{{csrf_token()}}',id:id},function(data){

    });
}
</script>

@endsection
@section('page-style')
<style>
  
</style>
@endsection