@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <span class="pagetitle">{{ $title }}</span>
  @if(Auth::user()?->role?->slug == 'vendor')
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
              <label for="store_type_id" class="form-label">Store Type</label>
              <select class="form-select form-select-md" name="store_type_id" id="store_type_id">
                @foreach($storeType as $st)
                  <option value="{{ $st->id }}">{{ $st->name }}</option>
                @endforeach  
              </select>
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
      {
    title: 'Status',
    data: 'name',
    render: function(data, type, row) {
      const isAdmin = `{{ Auth::user()?->role?->slug == 'admin' ? 'true' : 'false' }}`;
      if(isAdmin){
        return `<select class="form-select form-select-md" name="store_type_id" id="store_type_id">
@foreach($storeStatuses as $st)
    <option value="{{ $st->id }}" {{ $st->id == ${row->store_status->id} ? 'selected' : '' }}>
        {{ $st->name }}
    </option>
@endforeach
 
              </select>`
      }else{
       return `   <span style="background-color:${row?.store_status?.color}; color:#FFF; font-size:12px; padding:3px 5px; border-radius:25px">
                    ${row?.store_status?.name}
                </span>` 
      }
  
    }
},

      { title: 'NTN', data: 'ntn' },
      { 
        title: 'Store Type',
        data: 'store_type',
        render: function(data) {
          return data ? data.name : '';
        }
      },
      { title: 'Opening Time', data: 'opning_time' },
      { 
        title: 'Actions',
        data: null,
        render: function(data, type, row) {
          return `
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-sm btn-info" onclick="viewStore(${row.id})"><i class="bi bi-eye"></i></button>
              <button type="button" class="btn btn-sm btn-warning" onclick="editStore(${row.id})"><i class="bi bi-pencil text-white"></i></button>
              <button type="button" class="btn btn-sm btn-danger btn-delete" onclick="deleteStore(${row.id})"><i class="bi bi-trash"></i></button>
            </div>`;
        }
      }
    ],
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    pagingType: "simple_numbers"
  });

  // Handle form submission
  $('#storeForm').on('submit', function(event) {
    event.preventDefault();
    var action = $('#storeModal').data('action');
    var storeId = $('#storeId').val();
    var url = action === 'create' ? "/store-create" : `/stores/${storeId}`;
    var method = action === 'create' ? "POST" : "PUT";

    var formData = new FormData(this);
    $.ajax({
      url: url,
      type: method,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        table.ajax.reload();
        $('#storeModal').modal('hide');
        Swal.fire({
          position: "center",
          icon: "success",
          title: action === 'create' ? "Store created successfully" : "Store updated successfully",
          showConfirmButton: false,
          timer: 1500
        });
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

  // View store details
  window.viewStore = function(id) {
    $.ajax({
      url: `/stores/${id}`,
      type: 'GET',
      success: function(store) {
        $('#storeId').val(store.id);
        $('#storeName').val(store.name).prop('readonly', true);
        $('#store_type_id').val(store.store_type_id).prop('disabled', true);
        $('#storeNtn').val(store.ntn).prop('readonly', true);
        $('#storeThumbnail').prop('disabled', true);
        $('#storeMinDeleveryTime').val(store.min_delevery_time).prop('readonly', true);
        $('#storeMinOrder').val(store.min_order).prop('readonly', true);
        $('#storeOpeningTime').val(store.opning_time).prop('readonly', true);
        $('#storeAddress').val(store.address).prop('readonly', true);
        $('#storeLat').val(store.lat).prop('readonly', true);
        $('#storeLong').val(store.long).prop('readonly', true);
        $('#storeDeliveryType').val(store.delivery_type).prop('readonly', true);
        $('#storeDeliveryFee').val(store.delivery_fee).prop('readonly', true);
        $('#storeDeliveryRadius').val(store.delivery_radius).prop('readonly', true);
        $('#storeCommission').val(store.commission).prop('readonly', true);
        $('#storePlatformFee').val(store.platform_fee).prop('readonly', true);
        $('#storeVenuFee').val(store.venu_fee).prop('readonly', true);
        $('#modalTitleId').text('View Store');
        $('#storeForm').find(':input').prop('readonly', true);
        $('#storeModal .btn-primary').hide();
        $('#storeModal').modal('show');
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        alert('An error occurred while fetching store data');
      }
    });
  };

  // Edit store details
  window.editStore = function(id) {
    $.ajax({
      url: `/stores/${id}`,
      type: 'GET',
      success: function(store) {
        $('#storeId').val(store.id);
        $('#storeName').val(store.name).prop('readonly', false);
        $('#store_type_id').val(store.store_type_id).prop('disabled', false);
        $('#storeNtn').val(store.ntn).prop('readonly', false);
        $('#storeThumbnail').prop('disabled', false);
        $('#storeMinDeleveryTime').val(store.min_delevery_time).prop('readonly', false);
        $('#storeMinOrder').val(store.min_order).prop('readonly', false);
        $('#storeOpeningTime').val(store.opning_time).prop('readonly', false);
        $('#storeAddress').val(store.address).prop('readonly', false);
        $('#storeLat').val(store.lat).prop('readonly', false);
        $('#storeLong').val(store.long).prop('readonly', false);
        $('#storeDeliveryType').val(store.delivery_type).prop('readonly', false);
        $('#storeDeliveryFee').val(store.delivery_fee).prop('readonly', false);
        $('#storeDeliveryRadius').val(store.delivery_radius).prop('readonly', false);
        $('#storeCommission').val(store.commission).prop('readonly', false);
        $('#storePlatformFee').val(store.platform_fee).prop('readonly', false);
        $('#storeVenuFee').val(store.venu_fee).prop('readonly', false);
        $('#modalTitleId').text('Edit Store');
        $('#storeForm').find(':input').prop('readonly', false);
        $('#storeModal .btn-primary').text('Save Changes').show();
        $('#storeModal').modal('show');
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        alert('An error occurred while fetching store data');
      }
    });
  };

  // Delete store
  window.deleteStore = function(id) {
    if (confirm('Are you sure you want to delete this store?')) {
      $.ajax({
        url: `/stores/${id}`,
        type: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          table.ajax.reload();
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Store deleted successfully",
            showConfirmButton: false,
            timer: 1500
          });
        },
        error: function(xhr) {
          alert('Error deleting store');
          console.log(xhr.responseText);
        }
      });
    }
  };

  // Handle modal show event
  $('#storeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var action = button.data('action');
    $('#storeModal').data('action', action);

    if (action === 'view') {
      $('#storeModal .btn-primary').hide();
    } else {
      $('#storeModal .btn-primary').show();
    }
    $('#storeFormErrors').addClass('d-none');
  });
});
</script>
@endsection
