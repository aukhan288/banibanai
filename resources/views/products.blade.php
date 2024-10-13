@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <span class="pagetitle">{{ $title }}</span>
  @if(Auth::user()?->role?->slug == 'catering')
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#storeModal" data-action="create">Add New Product</button>
  @endif
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="productsTable">
              <thead>
                <tr>
                  <th>Thumbnail</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
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
        <h5 class="modal-title" id="modalTitleId">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="productForm" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="productId" name="id">
          
          <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>

          <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
          </div>

          <div id="productErrors" class="alert alert-danger d-none"></div>
          
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
  var table = $('#productsTable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: "/productList",
      type: "GET",
      dataSrc: function(json) {
        return json.data;
      }
    },
    columns: [
      {
        title: 'Thumbnail',
        data: 'thumbnail',
        render: function(data) {
          return data ? `<img style="height:40px; width:40px; border-radius:100px" src="${data}" alt="Product Thumbnail">` : '';
        }
      },
      { title: 'Name', data: 'name' },
      {
        title: 'Actions',
        data: null,
        render: function(data) {
          return `
            <div class="btn-group" role="group">
              @if(Auth::user()?->role?->slug == 'catering')
                <button type="button" class="btn btn-sm btn-warning" onclick="editProduct(${data.id})"><i class="bi bi-pencil"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduct(${data.id})"><i class="bi bi-trash"></i></button>
              @endif
            </div>`;
        }
      }
    ],
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    pagingType: "simple_numbers"
  });

  $('#productForm').on('submit', function(event) {
    event.preventDefault();
    var id = $('#productId').val();
    var url = id ? `/product/${id}` : '/product-create';
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
        $('#productErrors').html(errorHtml).removeClass('d-none');
      }
    });
  });

  $('#storeModal').on('hidden.bs.modal', function() {
    $('#productForm')[0].reset();
    $('#productErrors').addClass('d-none');
    $('#productId').val('');
  });
});

function editProduct(id) {
  $.get(`/product/${id}/edit`, function(data) {
    $('#modalTitleId').text('Edit Product');
    $('#productId').val(data.id);
    $('#name').val(data.name);
    $('#description').val(data.description);
    $('#thumbnail').val(''); // Reset file input
    $('#storeModal').modal('show');
  });
}

function deleteProduct(id) {
  if (confirm('Are you sure you want to delete this product?')) {
    $.ajax({
      url: `/product/${id}`,
      type: 'DELETE',
      success: function(response) {
        $('#productsTable').DataTable().ajax.reload();
      },
      error: function(xhr) {
        alert('Error deleting product');
      }
    });
  }
}
</script>
@endsection
