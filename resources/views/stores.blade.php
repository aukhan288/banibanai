@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h1>{{ $title }}</h1>
  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalId">Add New</button>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">User List</h4>
          <p class="card-description">
            Add class <code>.table-striped</code> for a striped table.
          </p>
          <div class="table-responsive">
            <table class="table table-striped" id="usersTable">
              <thead>
                <tr>
                  <th>Logo</th>
                  <th>Name</th>
                  <th>User Name</th>
                  <th>Srore Type</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <tr>
                          <td class="py-1">
                            <img src="{{ asset('images/b.webp') }}" alt="image">
                          </td>
                          <td>
                            Student Biryani
                          </td>
                          <td>
                            Zia khan
                          </td>
                          <td>
                            catering
                          </td>
                          <td>
                            May 15, 2015
                          </td>
                          <td>
                          <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-xs btn-success"><i class="mdi mdi-eye text-white"></i></button>
                          <button type="button" class="btn btn-xs btn-warning"><i class="mdi mdi-lead-pencil text-white"></i></button>
                          <button type="button" class="btn btn-xs btn-danger"><i class="mdi mdi-delete text-white"></i></button>
                        </div>
                          </td>
                        </tr>
              </tbody>
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
        <form id="createUserForm" action="">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required />
          </div>
          <div class="mb-3">
            <label for="storeType" class="form-label">Store Type</label>
            <select class="form-select" name="storeType" id="storeType" required>
              @foreach($storeType as $st)
                <option value="{{ $st->id }}">{{ $st->name }}</option>
              @endforeach
            </select>
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
//   $('#usersTable').DataTable({
//     "processing": true,
//     "serverSide": true, // Enable server-side processing
//     "ajax": {
//         "url": "/api/storeList/", // Your API endpoint
//         "type": "GET",
//         "dataSrc": function (json) {
//             // Verify data structure
//             console.log(json);
//             return json.data;
//         }
//     },
//     "columns": [
//         { "data": "name" }, // Name column
//         { "data": "email" }, // Name column
//         { 
//             "data": "role", // Access the role object directly
//             render: function(data, type, row) {
//                 // Check if the role object and its name property exist
//                 return  `${row?.role?.name}`;
//             }
//         },
//         {
//             "data": null,
//             "render": function(data, type, row) {
//                 return `
//                     <button class="btn btn-sm btn-warning">Edit</button> 
//                     <button class="btn btn-sm btn-danger">Delete</button>`;
//             }
//         }
//     ],
//     "pageLength": 10, // Number of rows per page
//     "lengthMenu": [5, 10, 25, 50], // Page length options
//     "pagingType": "simple_numbers" // Pagination controls
// });



    // Handle the form submission
//     $('#createUserForm').on('submit', function(event) {
//         event.preventDefault(); // Prevent default form submission

//         $.ajax({
//             url: "/api/user-create", // Replace with your API endpoint
//             type: "POST",
//             data: $(this).serialize(),
//             success: function(response) {
//                 $('#usersTable').DataTable().ajax.reload(); // Reload DataTable data
//                 $('#modalId').modal('hide'); // Close the modal
//                 Swal.fire({
//   position: "center",
//   icon: "success",
//   title: "Your work has been saved",
//   showConfirmButton: false,
//   timer: 1500
// });
//             },
//             error: function(xhr, status, error) {
//                 console.error(xhr.responseText);
//                 alert('An error occurred while creating the user');
//             }
//         });
//     });
});

</script>

@endsection