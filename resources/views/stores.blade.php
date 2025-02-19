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

          <h4><b>Add your Business Info</b></h4>
          <hr>

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="name" class="form-label">Store Name</label>
              <input type="text" id="storeName" class="form-control" name="name" placeholder="Store Name" required />
            </div>
            <div class="col-sm-6">
              <label for="storeType" class="form-label">Store Type</label>
              <input type="text" id="storeType" class="form-control" name="storeType" placeholder="Store Type"  />
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="storePurpose" class="form-label">Purpose of Store</label>
              <input type="text" id="storePurpose" class="form-control" name="storePurpose" placeholder="Purpose of Store"  />
            </div>
            <div class="col-sm-6">
              <label for="storeBankDetails" class="form-label">Bank Details</label>
              <input type="text" id="storeBankDetails" class="form-control" name="storeBankDetails" placeholder="Enter Bank Details"  />
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="storeOwner" class="form-label">Owner Name</label>
              <input type="text" id="storeOwner" class="form-control" name="storeOwner" placeholder="Owner Name"  />
            </div>
            <div class="col-sm-6">
              <label for="storeManager" class="form-label">Store Manager</label>
              <input type="text" id="storeManager" class="form-control" name="storeManager" placeholder="Store Manager Name"  />
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-4">
              <label for="ntn" class="form-label">NTN</label>
              <input type="number" id="storeNtn" class="form-control" name="ntn" placeholder="NTN" required />
            </div>
            <div class="col-sm-8">
              <label for="thumbnail" class="form-label">Thumbnail</label>
              <input type="file" id="storeThumbnail" class="form-control" name="thumbnail" placeholder="Thumbnail URL" />
            </div>
          </div>

          <h4><b>Add your store contact Info</b></h4>
          <hr>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="storeContactName" class="form-label">Name</label>
              <input type="text" id="storeContactName" class="form-control" name="storeContactName" placeholder="Name"  />
            </div>
            <div class="col-sm-6">
              <label for="storeContact1" class="form-label">Mobile Phone 1</label>
              <input type="tel" id="storeContact1" class="form-control" name="storeContact1" placeholder="Mobile phone 1"  />
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="storeContact2" class="form-label">Mobile Phone 2</label>
              <input type="tel" id="storeContact2" class="form-control" name="storeContact2" placeholder="Mobile phone 2"  />
            </div>
            <div class="col-sm-6">
              <label for="storeContactMail" class="form-label">Email</label>
              <input type="mail" id="storeContactMail" class="form-control" name="storeContactMail" placeholder="Email addrress"  />
            </div>
          </div>

          <!-- <div class="mb-3">
            <label for="name" class="form-label">Store Name</label>
            <input type="text" id="storeName" class="form-control" name="name" placeholder="Store Name" required />
          </div> -->
          <!-- <div class="row mb-3">
            <div class="col-sm-6">
         
            </div>
            <div class="col-sm-6">
              <label for="ntn" class="form-label">NTN</label>
              <input type="number" id="storeNtn" class="form-control" name="ntn" placeholder="NTN" required />
            </div>
          </div> -->
          <!-- <div class="row mb-3">
            <div class="col-sm-8">
              <label for="thumbnail" class="form-label">Thumbnail</label>
              <input type="file" id="storeThumbnail" class="form-control" name="thumbnail" placeholder="Thumbnail URL" />
            </div>
            <div class="col-sm-4">
              <label for="opning_time" class="form-label">Opening Time</label>
              <input type="time" id="storeOpeningTime" class="form-control" name="opning_time" required />
            </div>
          </div> -->
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

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="opning_time" class="form-label">Opening Time</label>
              <input type="time" id="storeOpeningTime" class="form-control" name="opning_time" />
            </div>
            <div class="col-sm-6">
              <label for="closing_time" class="form-label">Closing Time</label>
              <input type="time" id="storeOpeningTime" class="form-control" name="closing_time" />
            </div>
          </div>

          <hr>
          <h4><b>Delivery Detail</b></h4>
          <hr>
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="min_order" class="form-label">Minimum Order</label>
              <input type="number" id="storeMinOrder" class="form-control" name="min_order" placeholder="Minimum Order KG" required />
            </div>
            <div class="col-sm-6">
              <label for="min_order_price" class="form-label">Minimum Order Price</label>
              <input type="number" id="storeMinOrderPrice" class="form-control" name="min_order_price" placeholder="Minimum Order Price" required />
            </div>
          </div>

          <div class="row mb-3">
            <!-- <div class="col-sm-6">
              <label for="delivery_type" class="form-label">Delivery Type</label>
              <input type="text" id="DeliveryFeeType" class="form-control" name="delivery_type" placeholder="Delivery Type" required />
            </div> -->
            <div class="col-sm-6">
              <label for="DeliveryFeeType" class="form-label">Select Delivery Fee</label>
              <select id="DeliveryFeeType" class="form-control" name="deliveryFeetype" required>
                <option value="" disabled selected>Select Fee Type</option>
                <option value="fixed">Fixed</option>
                <option value="variable">Variable</option>
              </select>
            </div>
            <div class="col-sm-6">
              <label for="delivery_amount" class="form-label">Delivery Amount</label>
              <div class="d-flex gap-2">
                <input 
                  type="number" 
                  id="delivery_amount_min" 
                  class="form-control" 
                  name="delivery_amount_min" 
                  placeholder="min Rs.0" 
                  required 
                />
                <input 
                  type="number" 
                  id="delivery_amount_max" 
                  class="form-control" 
                  name="delivery_amount_max" 
                  placeholder="max Rs.0" 
                  required 
                />
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="delivery_radius" class="form-label">Delivery Radius</label>
              <input type="number" id="storeDeliveryRadius" step="0.01" class="form-control" name="delivery_radius" placeholder="Radius KM" required />
            </div>
            <div class="col-sm-6">
              <label for="deliveryBy" class="form-label">Delivery By</label>
              <select id="deliveryBy" class="form-control" name="deliveryBy" required>
                <option value="" disabled selected>Select delivery By</option>
                <option value="Store">Store</option>
                <option value="Self">Self</option>
                <option value="BaniBanai">BaniBanai</option>
              </select>
            </div>
          </div>

          <div class=" row mb-3">
             <div class="col-sm-12">
              <label for="deliverySlots" class="form-label">Delivery Slots</label>
              <div id="deliverySlotsContainer">
                <div class="d-flex gap-1 mb-2">
                  <input 
                    type="time" 
                    class="form-control" 
                    name="delivery_slots_start[]" 
                    required 
                    placeholder="Start Time" 
                  />
                  <input 
                    type="time" 
                    class="form-control" 
                    name="delivery_slots_end[]" 
                    required 
                    placeholder="End Time" 
                  />
                  <button type="button" class="btn btn-danger remove-slot">Remove</button>
                </div>
              </div>
              <button type="button" id="addSlotButton" class="btn btn-primary mt-2">Add Slot</button>
              </div>
          </div>

          <div class=" row mb-3">
             <div class="col-sm-6">
              <label for="orderTakingTime" class="form-label">Order Taking Time</label>
              <input type="number" id="orderTakingTime" class="form-control" name="orderTakingTime" placeholder="in hours" required />
             </div>
             <div class="col-sm-6">
              <label class="form-label">Days Shop Closed</label>
              <div id="daysShopClose">
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="daySaturday" 
                    name="days_shop_closed[]" 
                    value="Saturday" 
                  />
                  <label class="form-check-label" for="daySaturday">Saturday</label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="daySunday" 
                    name="days_shop_closed[]" 
                    value="Sunday" 
                  />
                  <label class="form-check-label" for="daySunday">Sunday</label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="dayMonday" 
                    name="days_shop_closed[]" 
                    value="Monday" 
                  />
                  <label class="form-check-label" for="dayMonday">Monday</label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="dayTuesday" 
                    name="days_shop_closed[]" 
                    value="Tuesday" 
                  />
                  <label class="form-check-label" for="dayTuesday">Tuesday</label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="dayWednesday" 
                    name="days_shop_closed[]" 
                    value="Wednesday" 
                  />
                  <label class="form-check-label" for="dayWednesday">Wednesday</label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="dayThursday" 
                    name="days_shop_closed[]" 
                    value="Thursday" 
                  />
                  <label class="form-check-label" for="dayThursday">Thursday</label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="dayFriday" 
                    name="days_shop_closed[]" 
                    value="Friday" 
                  />
                  <label class="form-check-label" for="dayFriday">Friday</label>
                </div>
              </div>
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
              <!-- <label for="delivery_fee" class="form-label">Delivery</label>
              <input type="number" id="storeDeliveryFee" class="form-control" name="delivery_fee" placeholder="Delivery Fee" required /> -->
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
  // delivery timing slots
  document.addEventListener("DOMContentLoaded", function () {
  const deliverySlotsContainer = document.getElementById("deliverySlotsContainer");
  const addSlotButton = document.getElementById("addSlotButton");

  // Add a new slot
  addSlotButton.addEventListener("click", () => {
    const newSlot = document.createElement("div");
    newSlot.classList.add("d-flex", "gap-2", "mb-2");

    newSlot.innerHTML = `
      <input 
        type="time" 
        class="form-control" 
        name="delivery_slots_start[]" 
        required 
        placeholder="Start Time" 
      />
      <input 
        type="time" 
        class="form-control" 
        name="delivery_slots_end[]" 
        required 
        placeholder="End Time" 
      />
      <button type="button" class="btn btn-danger remove-slot">Remove</button>
    `;

    deliverySlotsContainer.appendChild(newSlot);
  });

  // Remove a slot
  deliverySlotsContainer.addEventListener("click", (e) => {
    if (e.target.classList.contains("remove-slot")) {
      e.target.closest("div").remove();
    }
  });
});
//End time slots
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
