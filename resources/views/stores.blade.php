@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <span class="pagetitle">{{ $title }}</span>
  @if(Auth::user()?->role?->slug == 'catering')
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#storeModal" data-action="create">Add New</button>
  @endif
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="storesTable"></table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Store Modal -->
<div class="modal fade" id="storeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Add New Store</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="storeForm" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="storeId">
          <div class="mb-3">
            <label for="name" class="form-label">Store Name</label>
            <input type="text" id="storeName" class="form-control" name="name" placeholder="Store Name" required />
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
         
            </div>
            <div class="col-sm-6">
              <label for="ntn" class="form-label">NTN</label>
              <input type="number" id="storeNtn" class="form-control" name="ntn" placeholder="NTN" required />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-8">
              <label for="thumbnail" class="form-label">Thumbnail</label>
              <input type="file" id="storeThumbnail" class="form-control" name="thumbnail" placeholder="Thumbnail URL" />
            </div>
            <div class="col-sm-4">
              <label for="opning_time" class="form-label">Opening Time</label>
              <input type="time" id="storeOpeningTime" class="form-control" name="opning_time" required />
            </div>
          </div>
          <hr>
          <h4><b>Location</b></h4>
          <hr>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="storeAddress" class="form-control" name="address" placeholder="Address" required />
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="long" class="form-label">Longitude</label>
              <input type="number" id="storeLong" step="0.000001" class="form-control" name="long" placeholder="Longitude" required />
            </div>
            <div class="col-sm-6">
              <label for="lat" class="form-label">Latitude</label>
              <input type="number" id="storeLat" step="0.000001" class="form-control" name="lat" placeholder="Latitude" required />
            </div>
          </div>
          <hr>
          <h4><b>Delivery Detail</b></h4>
          <hr>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="min_delevery_time" class="form-label">Minimum Time</label>
              <input type="text" id="storeMinDeleveryTime" class="form-control" name="min_delevery_time" placeholder="Minimum Delivery Time" required />
            </div>
            <div class="col-sm-6">
              <label for="min_order" class="form-label">Minimum Order</label>
              <input type="number" id="storeMinOrder" step="0.01" class="form-control" name="min_order" placeholder="Minimum Order" required />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="delivery_type" class="form-label">Type</label>
              <input type="text" id="storeDeliveryType" class="form-control" name="delivery_type" placeholder="Delivery Type" required />
            </div>
            <div class="col-sm-6">
              <label for="delivery_radius" class="form-label">Radius</label>
              <input type="number" id="storeDeliveryRadius" step="0.01" class="form-control" name="delivery_radius" placeholder="Delivery Radius" required />
            </div>
          </div>
          <hr>
          <h4><b>Fee Detail</b></h4>
          <hr>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="commission" class="form-label">Commission</label>
              <input type="number" id="storeCommission" class="form-control" name="commission" placeholder="Commission" required />
            </div>
            <div class="col-sm-6">
              <label for="platform_fee" class="form-label">Platform</label>
              <input type="number" id="storePlatformFee" class="form-control" name="platform_fee" placeholder="Platform Fee" required />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="delivery_fee" class="form-label">Delivery</label>
              <input type="number" id="storeDeliveryFee" class="form-control" name="delivery_fee" placeholder="Delivery Fee" required />
            </div>
            <div class="col-sm-6">
              <label for="venu_fee" class="form-label">Venue <small>(Optional)</small></label>
              <input type="number" id="storeVenuFee" class="form-control" name="venu_fee" placeholder="Venue Fee" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
        <div id="storeFormErrors" class="alert alert-danger d-none"></div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var table = $('#storesTable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: "/storeList",
      type: "GET",
      dataSrc: function(json) {
        return json.data;
      }
    },
    columns: [
      {
        title: 'Logo',
        data: 'thumbnail',
        render: function(data) {
          return data ? `<img style="height:40px; width:40px; border-radius:100px" src="${data}" alt="Store Logo">` : '';
        }
      },
      { title: 'Name', data: 'name' },
      // {
      //   title: 'Status',
      //   data: 'store_status',
      //   render: function(data, type, row) {
      //     console.log(row);
          
      //     const isAdmin = `{{ Auth::user()?->role?->slug == 'admin' ? 'true' : 'false' }}`;
       
      //   }
      // },
      { title: 'NTN', data: 'ntn' },
      { title: 'Opening Time', data: 'opning_time' },
      {
        title: 'Actions',
        data: null,
        render: function(data, type, row) {
          return `
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-sm btn-info" onclick="viewStore(${row.id})"><i class="bi bi-eye"></i></button>
              @if(Auth::user()?->role?->slug == 'vendor')
                <button type="button" class="btn btn-sm btn-warning" onclick="editStore(${row.id})"><i class="bi bi-pencil"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteStore(${row.id})"><i class="bi bi-trash"></i></button>
              @endif
            </div>`;
        }
      }
    ],
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    pagingType: "simple_numbers"
  });

  $('#storeForm').on('submit', function(event) {
    event.preventDefault();
    var id = $('#storeId').val();
    var url = id ? `/stores/${id}` : '/store-create';
    var method = id ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      type: method,
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function(response) {
        $('#storeModal').modal('hide');
        table.ajax.reload();
      },
      error: function(xhr) {
        var errors = xhr.responseJSON.errors;
        var errorHtml = '<ul>';
        for (var key in errors) {
          errors[key].forEach(function(error) {
            errorHtml += '<li>' + error + '</li>';
          });
        }
        errorHtml += '</ul>';
        $('#storeFormErrors').html(errorHtml).removeClass('d-none');
      }
    });
  });

  $('#storeModal').on('hidden.bs.modal', function() {
    $('#storeForm')[0].reset();
    $('#storeFormErrors').addClass('d-none');
    $('#storeId').val('');
  });
});

// Define your viewStore, editStore, deleteStore, and updateStoreStatus functions here
</script>
@endsection
