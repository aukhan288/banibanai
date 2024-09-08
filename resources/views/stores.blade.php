@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h1>{{ $title }}</h1>
  @if(Auth::user()?->role?->slug=='vendor')
  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalId">Add New Store</button>
  @endif
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="storesTable">
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Body -->
<div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Add New Store</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createStoreForm" action="" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="name" class="form-label">Store Name</label>
            <input type="text" class="form-control" name="name" placeholder="Store Name" required />
          </div>
            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" />
          <div class="row mb-3">
            <div class="col-sm-6">
            <label for="" class="form-label">Store Type</label>
            <select
              class="form-select form-select-md"
              name="store_type_id"
              id="store_type_id"
            >
            @foreach($storeType as $st)
              <option value="{{$st?->id}}">{{$st?->name}}</option>
            @endforeach  
            </select>
            
            </div>
            <div class="col-sm-6">
            <label for="ntn" class="form-label">NTN</label>
            <input type="number" class="form-control" name="ntn" placeholder="NTN" required />
           </div>
            </div>
            <div class="row mb-3">
            <div class="col-sm-8">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" name="thumbnail" placeholder="Thumbnail URL" required />
       
            </div>
            <div class="col-sm-4">
            <label for="opning_time" class="form-label">Opening Time</label>
            <input type="time" class="form-control" name="opning_time" required />
          </div>
          </div>
          <hr>
          <h4><b>Location</b></h4>
          <hr>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Address" required />
          </div>
         <div class="row mb-3">
          <div class="col-sm-6">

          <label for="long" class="form-label">Longitude</label>
            <input type="number" step="0.000001" class="form-control" name="long" placeholder="Longitude" required />
          </div>
          <div class="col-sm-6">
          <label for="lat" class="form-label">Latitude</label>
            <input type="number" step="0.000001" class="form-control" name="lat" placeholder="Latitude" required />
         </div>
         </div>
         <hr>
         <h4><b>Delivery Detail</b></h4>
         <hr>
         <div class="row mb-3">
            <div class="col-sm-6">
            <label for="min_delevery_time" class="form-label">Minimum  Time</label>
            <input type="text" class="form-control" name="min_delevery_time" placeholder="Minimum Delivery Time" required />
            </div>
            <div class="col-sm-6">
            <label for="min_order" class="form-label">Minimum Order</label>
            <input type="number" step="0.01" class="form-control" name="min_order" placeholder="Minimum Order" required />
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-sm-6">
            <label for="delivery_type" class="form-label">Type</label>
            <input type="text" class="form-control" name="delivery_type" placeholder="Delivery Type" required />
            </div>
            <div class="col-sm-6">
            <label for="delivery_radius" class="form-label">Radius</label>
            <input type="number" step="0.01" class="form-control" name="delivery_radius" placeholder="Delivery Radius" required />
            </div>
         </div>
          <hr>
          <h4><b>Fee Detail</b></h4>
          <hr>
       <div class="row mb-3">
        <div class="col-sm-6">
        <label for="commission" class="form-label">Commission</label>
            <input type="number" class="form-control" name="commission" placeholder="Commission" required />
        </div>
        <div class="col-sm-6">
        <label for="platform_fee" class="form-label">Platform</label>
            <input type="number" class="form-control" name="platform_fee" placeholder="Platform Fee" required />
        </div>
    
       </div>
       <div class="row mb-3">
       <div class="col-sm-6">
            <label for="delivery_fee" class="form-label">Delivery</label>
            <input type="number" class="form-control" name="delivery_fee" placeholder="Delivery Fee" required />
          </div>
       <div class="col-sm-6">
        <label for="venu_fee" class="form-label">Venue <span><small>(Optional)</small> </span></label>
            <input type="number" class="form-control" name="venu_fee" placeholder="Venue Fee" />
        
        </div>
       </div>
     
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
 $(document).ready(function() {
   $('#storesTable').DataTable({
     "processing": true,
     "serverSide": true,
     "ajax": {
         "url": "/api/storeList/", 
         "type": "GET",
         "dataSrc": function (json) {
             console.log(json);
             return json.data;
         }
     },
     "columns": [
      { "data": "", 'title': 'Logo', 
          "render": function(data, type, row) {
            return `<img style="height:40px; width:40px; border-radius:100px" src="${row?.thumbnail}" alt="Italian Trulli">`;
          }
          },
         { "data": "name", 'title': 'Name' },
         { "data": "user_id", 'title': 'User' },
         { "data": "store_type_id", 'title': 'Store Type' },
         { "data": "min_delevery_time", 'title': 'Minimum Delivery Time' },
         { "data": "min_order", 'title': 'Minimum Order' },
         { "data": "rating", 'title': 'Rating' },
         { "data": "opning_time", 'title': 'Opening Time' },
         { "data": "address", 'title': 'Address' },
         { "data": "lat", 'title': 'Latitude' },
         { "data": "long", 'title': 'Longitude' },
         { "data": "ntn", 'title': 'NTN' },
         { "data": "delivery_type", 'title': 'Delivery Type' },
         { "data": "delivery_fee", 'title': 'Delivery Fee' },
         { "data": "delivery_radius", 'title': 'Delivery Radius' },
         { "data": "commission", 'title': 'Commission' },
         { "data": "platform_fee", 'title': 'Platform Fee' },
         { "data": "venu_fee", 'title': 'Venue Fee' },
         {
             "data": null,
             "title":"Action",
             "render": function(data, type, row) {
              return `
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-sm btn-warning" onclick="editStore(${row?.id})"><i class="bi bi-pencil text-white"></i></button>
                  <button type="button" class="btn btn-sm btn-danger btn-delete" onclick="deleteStore(${row?.id})"><i class="bi bi-trash"></i></button>
                </div>`;
             }
         }
     ],
     "pageLength": 10, 
     "lengthMenu": [5, 10, 25, 50],
     "pagingType": "simple_numbers" 
  });

    $('#createStoreForm').on('submit', function(event) {
        event.preventDefault(); 
        var formData = new FormData(this);
        $.ajax({
            url: "/api/store-create", 
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set to false to tell jQuery not to set the content type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token if needed
            },
            success: function(response) {
                $('#storesTable').DataTable().ajax.reload(); 
                $('#modalId').modal('hide');
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "Store has been added successfully",
                  showConfirmButton: false,
                  timer: 1500
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while creating the store');
            }
        });
    });
});

window.deleteStore = function(id) {
    var table = $('#storesTable').DataTable();
    var currentPage = table.page();

    $.ajax({
      url: `/api/stores/${id}`,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        table.row($(`.btn-delete[onclick="deleteStore(${id})"]`).parents('tr')).remove().draw(false);
        table.page(currentPage).draw(false);
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
};
</script>

@endsection
