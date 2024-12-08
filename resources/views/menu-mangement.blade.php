@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <span class="pagetitle">{{ $title }}</span>
  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#menuModal" data-action="create">Add New</button>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="menusTable">
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- User Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="menuModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="menuModalTitle">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="menuForm" action="">
          @csrf
          <div id="userFormErrors" class="alert alert-danger d-none"></div>
          <input type="hidden" id="userId" name="id" />
          
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required />
          </div>
          
          <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*" required />
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description" required></textarea>
          </div>

          <div class="mb-3">
            <label for="store_id" class="form-label">Store</label>
            <select class="form-select form-select-md" name="store_id" id="store_id">
              @foreach($stores as $store)
                <option value="{{ $store->id }}">{{ $store->name }}</option>
              @endforeach  
            </select>
          </div>

          <hr>
          <h4>Item</h4>
          <hr>
          <div id="productRows">
            <div class="row mb-3 product-row">
              <div class="col-sm-5">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select form-select-md category_id" onchange="fetchProducts(this)">
                  <option value="">Select a category</option>
                  @foreach($Categories as $Category)
                    <option value="{{ $Category->id }}">{{ $Category->name }}</option>
                  @endforeach  
                </select>
              </div>
              <div class="col-sm-5">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-select form-select-md product_id">
                  <option value="">Select a product</option>
                </select>
              </div>
              <div class="col-sm-2">
                <button type="button" class="btn btn-sm btn-danger mt-4" onclick="removeProductRow(this)">Remove</button>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-primary" onclick="addProductRow()">Add Product</button>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="menuModalSubmit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function() {
  var table = $('#menusTable').DataTable({
    'responsive': true,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "/menuList/",
      "type": "GET",
      "dataSrc": function(json) {
        console.log(json);
        return json.data;
      }
    },
    "columns": [
      { 'title': 'Thumbnail', "data": "",
        "render": function(data, type, row) {
          return `<img src=${row?.thumbnail}/>`
        }
       },
      { 'title': 'Name', "data": "name" },
      { 'title': 'Discription','data':'description'},
      { 'title': 'Actions',
        "data": null,
        "render": function(data, type, row) {
          return `
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-sm btn-info" onclick="viewMenu(${row?.id})"><i class="bi bi-eye"></i></button>
              <button type="button" class="btn btn-sm btn-warning" onclick="editMenu(${row?.id})"><i class="bi bi-pencil text-white"></i></button>
              <button type="button" class="btn btn-sm btn-danger btn-delete" onclick="deleteMenu(${row?.id})"><i class="bi bi-trash"></i></button>
            </div>`;
        }
      }
    ],
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50],
    "pagingType": "simple_numbers"
  });

  // Handle the form submission for creating and updating a user
  $('#menuForm_1').on('submit', function(event) {
    event.preventDefault();
    var action = $('#menuModal').data('action');
    var userId = $('#menuId').val();
    var url = action === 'create' ? "/menu-create" : `/menu/${menuId}`;
    var method = action === 'create' ? "POST" : "PUT";

    $.ajax({
      url: url,
      type: method,
      data: $(this).serialize(),
      success: function(response) {
        table.ajax.reload();
        $('#menuModal').modal('hide');
        Swal.fire({
          position: "center",
          icon: "success",
          title: action === 'create' ? "Menu created successfully" : "Menu updated successfully",
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
        $('#userFormErrors').html(errorHtml).removeClass('d-none');
      }
    });
  });

  // Function to open the modal for viewing a user
  window.viewUser = function(id) {
    $.ajax({
      url: `/menus/${id}`,
      type: 'GET',
      success: function(user) {
        $('#userId').val(user.id);
        $('#userName').val(user.name).prop('readonly', true);
        $('#userEmail').val(user.email).prop('readonly', true);
        $('#userPassword').val('').prop('disabled', true);
        $('#userModalTitle').text('View User');
        $('#userModalSubmit').hide();
        $('#userFormErrors').addClass('d-none');
        $('#userModal').modal('show');
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        alert('An error occurred while fetching user data');
      }
    });
  };

  // Function to open the modal for editing a user
  window.editMenu = function(id) {
    $.ajax({
      url: `/menu/${id}`,
      type: 'GET',
      success: function(user) {
        $('#userId').val(user.id);
        $('#userName').val(user.name).prop('readonly', false);
        $('#userEmail').val(user.email).prop('readonly', false);
        $('#userPassword').val('');
        $('#userModalTitle').text('Edit User');
        $('#userModalSubmit').text('Save Changes').show();
        $('#userFormErrors').addClass('d-none');
        $('#userModal').modal('show');
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        alert('An error occurred while fetching user data');
      }
    });
  };

  // Function to delete a user
  window.deleteMenu = function(id) {
    var table = $('#menusTable').DataTable();
    var currentPage = table.page();

    $.ajax({
      url: `/menu/${id}`,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        table.row($(`.btn-delete[onclick="deleteUser(${id})"]`).parents('tr')).remove().draw(false);
        table.page(currentPage).draw(false);
        Swal.fire({
          position: "center",
          icon: "success",
          title: "User deleted successfully",
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

  // Handle the modal toggle to set form action
  $('#menuModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var action = button.data('action'); // Extract info from data-* attributes
    $('#menuModal').data('action', action);
  });
});
// Sample data - you would replace this with your actual product data
function fetchProducts(selectElement) {
    const categoryId = selectElement.value;
    const productSelect = selectElement.closest('.product-row').querySelector('.product_id');

    // Clear existing options
    productSelect.innerHTML = '<option value="">Select a product</option>';

    if (categoryId) {
      // Make a GET request to the server
      fetch(`/products/${categoryId}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success && data.data) {
            data.data.forEach(product => {
              const option = document.createElement('option');
              option.value = product.id;
              option.textContent = product.name;
              productSelect.appendChild(option);
            });
          } else {
            console.error(data.message);
          }
        })
        .catch(error => console.error('Fetch error:', error));
    }
  }

  function addProductRow() {
    const productRows = document.getElementById('productRows');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-3 product-row';
    newRow.innerHTML = `
      <div class="col-sm-5">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select form-select-md category_id" onchange="fetchProducts(this)">
          <option value="">Select a category</option>
          @foreach($Categories as $Category)
            <option value="{{ $Category->id }}">{{ $Category->name }}</option>
          @endforeach  
        </select>
      </div>
      <div class="col-sm-5">
        <label for="product_id" class="form-label">Product</label>
        <select class="form-select form-select-md product_id">
          <option value="">Select a product</option>
        </select>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-sm btn-danger mt-4" onclick="removeProductRow(this)">Remove</button>
      </div>
    `;
    productRows.appendChild(newRow);
  }

  function removeProductRow(button) {
    const row = button.closest('.product-row');
    row.remove();
  }

  document.getElementById('menuForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Collect selected category and product values
    const productData = [];
    document.querySelectorAll('.product-row').forEach(row => {
        const categoryId = row.querySelector('.category_id').value;
        const productId = row.querySelector('.product_id').value;

        if (categoryId && productId) {
            productData.push({ category_id: categoryId, product_id: productId });
        }
    });

    formData.append('products', JSON.stringify(productData));

    fetch('/add-menu', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        },
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Form submitted successfully');
                // Close the modal or reset the form if needed
            } else {
                alert('Error submitting form');
            }
        })
        .catch(error => console.error('Error submitting form:', error));
});

</script>

@endsection
