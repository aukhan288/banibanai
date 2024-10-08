@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h1>{{ $title }}</h1>
  @if(Auth::check() && Auth::user()->role->slug === 'catering')
  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalId">Add New</button>
  @endif
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Catering List</h4>
          <p class="card-description">
            Add class <code>.table-striped</code> for a striped table.
          </p>
          <div class="table-responsive">
            <table class="table table-striped" id="usersTable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>User Name</th>
                  <th>Address</th>
                  <th>Actions</th>
                </tr>
              </thead>
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
        <h5 class="modal-title" id="modalTitleId">Add New Catering</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createCateringForm" action="">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required />
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" required />
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
  $('#usersTable').DataTable({
    "processing": true,
    "serverSide": true, // Enable server-side processing
    "ajax": {
        "url": "/api/cateringList/", // Your API endpoint
        "type": "GET",
        "dataSrc": function (json) {
            // Verify data structure
            console.log(json);
            return json.data;
        }
    },
    "columns": [
        { "data": "name" }, // Name column
        {
            "data": null,
            "render": function(data, type, row) {
                return `${row?.user?.name}`;
            }
        },
        { "data": "address" }, // Name column

        {
            "data": null,
            "render": function(data, type, row) {
                return `
                    <button class="btn btn-sm btn-warning">Edit</button> 
                    <button class="btn btn-sm btn-danger">Delete</button>`;
            }
        }
    ],
    "pageLength": 10, // Number of rows per page
    "lengthMenu": [5, 10, 25, 50], // Page length options
    "pagingType": "simple_numbers" // Pagination controls
});



    // Handle the form submission
    $('#createCateringForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "/api/catering-create", // Replace with your API endpoint
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#usersTable').DataTable().ajax.reload(); // Reload DataTable data
                $('#modalId').modal('hide'); // Close the modal
                Swal.fire({
  position: "center",
  icon: "success",
  title: "Your work has been saved",
  showConfirmButton: false,
  timer: 1500
});
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while creating the user');
            }
        });
    });
});

</script>

@endsection
