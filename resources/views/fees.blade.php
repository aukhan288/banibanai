@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3 ">
  <h1>{{ $title }}</h1>
  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalId">Add New</button>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="feesTable">
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
        <h5 class="modal-title" id="modalTitleId">Add New Fee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createFeeForm" action="">
          <div class="mb-3">
            <label for="priceFrom" class="form-label">Price From</label>
            <input type="text" class="form-control" name="priceFrom" id="" placeholder="Price From" required />
          </div>
          <div class="mb-3">
            <label for="priceTo" class="form-label">Price To</label>
            <input type="text" class="form-control" name="priceTo" id="priceTo" placeholder="Price To" required />
          </div>
          <div class="mb-3">
            <label for="commision" class="form-label">Commision</label>
            <input type="text" class="form-control" name="commision" id="commision" placeholder="Commision" required />
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
   $('#feesTable').DataTable({
     "processing": true,
     "serverSide": true, // Enable server-side processing
     "ajax": {
         "url": "/api/feeList/", // Your API endpoint
         "type": "GET",
         "dataSrc": function (json) {
             // Verify data structure
             console.log(json);
             return json.data;
         }
     },
     "columns": [
         { "data": "from",'title':'Price From' }, // Name column
         { "data": "to",'title':'Price To' }, // Name column
         { "data": "commission",'title':'Commission' }, // Name column
         {
             "data": null,
             "title":"Action",
             "render": function(data, type, row) {
              return `
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-sm btn-warning" onclick="editFee(${row?.id})"><i class="bi bi-pencil text-white"></i></button>
                  <button type="button" class="btn btn-sm btn-danger btn-delete" onclick="deleteFee(${row?.id})"><i class="bi bi-trash"></i></button>
                </div>`;
             }
         }
     ],
     "pageLength": 10, // Number of rows per page
     "lengthMenu": [5, 10, 25, 50], // Page length options
     "pagingType": "simple_numbers" // Pagination controls
 });



    // Handle the form submission
    $('#createFeeForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "/api/fee-create", // Replace with your API endpoint
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


// Function to delete a user
window.deleteFee = function(id) {
    var table = $('#feesTable').DataTable();
    var currentPage = table.page();

    $.ajax({
      url: `/api/fees/${id}`,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        table.row($(`.btn-delete[onclick="deleteFee(${id})"]`).parents('tr')).remove().draw(false);
        table.page(currentPage).draw(false);
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Fee deleted successfully",
          showConfirmButton: false,
          timer: 1500
        });
      },
      error: function(xhr) {
        alert('Error deleting user');
        console.log(xhr.responseText);
      }
    });
  };

</script>

@endsection
