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
            <table class="table table-striped" id="storesTable">
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
        <h5 class="modal-title" id="modalTitleId">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="categoryId" name="id">
          
          <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>

          <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category</label>
            <select class="form-select" id="parent_id" name="parent_id">
              <option value="">Select Parent Category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
          </div>

          <div id="categoryErrors" class="alert alert-danger d-none"></div>
          
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
  var table = $('#storesTable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: "/categoryList",
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
          return data ? `<img style="height:40px; width:40px; border-radius:100px" src="${data}" alt="Category Thumbnail">` : '';
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
                <button type="button" class="btn btn-sm btn-warning" onclick="editCategory(${data.id})"><i class="bi bi-pencil"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCategory(${data.id})"><i class="bi bi-trash"></i></button>
              @endif
            </div>`;
        }
      }
    ],
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    pagingType: "simple_numbers"
  });

  $('#categoryForm').on('submit', function(event) {
    event.preventDefault();
    var id = $('#categoryId').val();
    var url = id ? `/category/${id}` : '/category-create';
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
        $('#categoryErrors').html(errorHtml).removeClass('d-none');
      }
    });
  });

  $('#storeModal').on('hidden.bs.modal', function() {
    $('#categoryForm')[0].reset();
    $('#categoryErrors').addClass('d-none');
    $('#categoryId').val('');
  });
});

function editCategory(id) {
  $.get(`/category/${id}/edit`, function(data) {
    $('#modalTitleId').text('Edit Category');
    $('#categoryId').val(data.id);
    $('#name').val(data.name);
    $('#description').val(data.description);
    $('#parent_id').val(data.parent_id); // Set parent category
    $('#thumbnail').val(''); // Reset file input
    $('#storeModal').modal('show');
  });
}

function deleteCategory(id) {
  if (confirm('Are you sure you want to delete this category?')) {
    $.ajax({
      url: `/category/${id}`,
      type: 'DELETE',
      success: function(response) {
        $('#storesTable').DataTable().ajax.reload();
      },
      error: function(xhr) {
        alert('Error deleting category');
      }
    });
  }
}
</script>
@endsection
