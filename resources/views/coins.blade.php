@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Coins</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Coins</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">         
            <ul class="navbar-nav ms-md-auto justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
                </a>
            </li>            
            </ul>
        </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid">
      <div class="page-header min-height-150 border-radius-xl" style="background-image: url('../img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="{{ asset('img/small-logos/icon-sun-cloud.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1"> Personal Coins </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>

    <div class="container-fluid py-4 fit-content-body">      
      <div class="row gx-4 mt-4">
        <div class="col-md-12 m-auto m_rate_box">
          <div class="card mt-4" id="coins">
            <div class="card-body pt-2 pb-1 tab-container">
                <div class="ps-5 ms-3">
                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                        <p class="text-sm font-weight-bold my-auto ps-sm-2">Enter Coin</p>
                        <input id="coin_name" class="form-control form-control-sm ms-sm-auto mt-sm-0 mt-2 w-40 c-mt-2" type="text" value=""
                            data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Input the coin name!"
                            data-bs-original-title="Input the coin name!">
                        <button id="btn_add_coin" class="btn btn-sm bg-gradient-primary my-sm-auto mt-2 mb-0" type="button">
                            <i class="fas fa-plus me-2"></i>Add
                        </button>
                    </div>
                </div>
                <div id="coin_items">
                    @foreach ($all_coins as $coin)
                        <div class="d-flex mt-3 coin-item" id="coin_{{$coin['id']}}" data-id="{{ $coin['id'] }}" data-name="{{ $coin['name'] }}">
                            <div class="my-auto ms-3">
                                <div class="h-100 d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{$coin['name']}}</h6>
                                        <p>{{$coin['address']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <a class="btn text-dark text-gradient px-3 mb-0 btn_edit"
                                  href="javascript:;" data-id="{{ $coin['id'] }}" data-name="{{ $coin['name'] }}">
                                    <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>Edit
                                </a>
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete"
                                  href="javascript:;" data-name="{{$coin['name']}}">
                                    <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete
                                </a>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                    @endforeach
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="coinModalMessage" tabindex="-1" aria-labelledby="coinModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coinModalLabel">Update Coin</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <input type="hidden" id="coin_id" name="id">
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <label class="col-form-label c-font-size-12">Name:</label>
                            </div>
                            <div class="col-md-9 my-2">
                                <input type="text" class="form-control form-control-alternative" id="name" name="name" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <label class="col-form-label c-font-size-12">Address:</label>
                            </div>
                            <div class="col-md-9 my-2">
                                <input type="text" class="form-control form-control-alternative" id="address" name="address" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <label class="col-form-label c-font-size-12">Background:</label>
                            </div>
                            <div class="col-md-9 my-2">
                                <select class="form-control form-control-alternative" id="background_classname" name="background_classname">
                                    <option value="bg-gradient-primary">bg-gradient-primary</option>
                                    <option value="bg-gradient-warning">bg-gradient-warning</option>
                                    <option value="bg-gradient-success">bg-gradient-success</option>
                                    <option value="bg-gradient-info">bg-gradient-info</option>
                                    <option value="bg-gradient-danger">bg-gradient-danger</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-gradient-primary" id="saveButton">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@parent
<script>
  $(document).ready(function () {
    // Add Host
    $('#btn_add_coin').on('click', function () {
      const coinName = $('#coin_name').val().trim();

      if (!coinName) {
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Coin name cannot be empty!',
              confirmButtonText: 'OK',
          });
          return;
      }

      $.ajax({
          type: 'POST',
          url: '{{ route("coin_store") }}', // Shared API for coin
          data: {
              name: coinName,
              _token: '{{ csrf_token() }}',
          },
          success: function (response) {
              if (response.status === true) {
                  // Add the new coin to the list
                  $('#coin_items').append(`
                      <div class="d-flex mt-3 coin-item" id="coin_${response.coin.id}" data-id="${response.coin.id}" data-name="${coinName}">
                          <div class="my-auto ms-3">
                              <div class="h-100 d-flex align-items-center">
                                  <div>
                                      <h6 class="mb-0">${coinName}</h6>
                                      <p>${response.coin.address}</p>
                                  </div>
                              </div>
                          </div>
                          <div class="ms-auto text-end">
                            <a class="btn text-dark text-gradient px-3 mb-0 btn_edit"
                                  href="javascript:;" data-id="${response.coin.id}" data-name="${coinName}">
                                    <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>Edit
                            </a>
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete"
                                href="javascript:;" data-name="${coinName}">
                                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete
                            </a>
                          </div>
                      </div>
                      <hr class="horizontal dark">
                  `);

                  // Clear the input field
                  $('#coin_name').val('');

                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Coin added successfully!',
                      confirmButtonText: 'OK',
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.message || 'Failed to add coin.',
                      confirmButtonText: 'OK',
                  });
              }
          },
          error: function (xhr) {
              console.error('Error:', xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to add coin. Please try again.',
                  confirmButtonText: 'OK',
              });
          },
      });
    });

    // Delete Coin
    $(document).on('click', '.btn_delete', function () {
      const coinName = $(this).data('name');

      Swal.fire({
          title: 'Are you sure?',
          text: `You are about to delete the coin "${coinName}".`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel',
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  type: 'POST',
                  url: '{{ route("coin_destory") }}', // Shared API for customer and coin
                  data: {
                      name: coinName,
                      _token: '{{ csrf_token() }}',
                  },
                  success: function (response) {
                      if (response.status === true) {
                          // Remove the coin from the DOM
                          $(`.btn_delete[data-name="${coinName}"]`).closest('.coin-item').fadeOut('slow', function () {
                              $(this).remove();
                          });

                          Swal.fire({
                              icon: 'success',
                              title: 'Deleted!',
                              text: `coin "${coinName}" removed successfully.`,
                              confirmButtonText: 'OK',
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: response.message || 'Failed to remove coin.',
                              confirmButtonText: 'OK',
                          });
                      }
                  },
                  error: function (xhr) {
                      console.error('Error:', xhr.responseText);
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Failed to remove coin. Please try again.',
                          confirmButtonText: 'OK',
                      });
                  },
              });
          }
      });
    });

    $(document).on('click', '.btn_edit', function () {
      const coinId = $(this).data('id');
      const coinName = $(this).data('name');

      // Fetch customer data via API
      $.ajax({
        type: 'GET',
        url: `/coins/${coinId}`,
        success: function (response) {
            if (response.status === true) {
                const coin = response.single;

                // Populate modal fields with customer data
                $('#coin_id').val(coinId);
                $('#coinModalLabel').text(`Update Coin for ${coin.name}`);

                // Populate the input fields dynamically
                Object.keys(coin).forEach((key) => {
                    $(`#${key}`).val(coin[key]);
                });

                // Show the modal
                $('#coinModalMessage').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch coin data.',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch customer data. Please try again.',
            });
        },
      });    
    });

    $(document).on('click', '.coin-item', function () {

        // Prevent event from firing when clicking on .btn-delete
        if ($(event.target).closest('.btn_delete').length) {
            return;
        }

      const coinId = $(this).data('id');
      const coinName = $(this).data('name');

      // Fetch customer data via API
      $.ajax({
        type: 'GET',
        url: `/coins/${coinId}`,
        success: function (response) {
            if (response.status === true) {
                const coin = response.single;

                // Populate modal fields with customer data
                $('#coin_id').val(coinId);
                $('#coinModalLabel').text(`Update Coin for ${coin.name}`);

                // Populate the input fields dynamically
                Object.keys(coin).forEach((key) => {
                    $(`#${key}`).val(coin[key]);
                });

                // Show the modal
                $('#coinModalMessage').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch coin data.',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch customer data. Please try again.',
            });
        },
      });    
    });

    // Save Button Click Handler
    $('#saveButton').on('click', function () {
      const formData = $('#updateForm').serializeArray();
      const data = {
          id: $('#coin_id').val(),
          name: $('#name').val(),
          address: $('#address').val(),
          background_classname: $('#background_classname').val(),
      };

      $.ajax({
          type: 'POST',
          url: '{{ route("coin_update") }}',
          data: data,
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          success: function (response) {
              if (response.status === true) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Coin updated successfully!',
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.message || 'Failed to update coin.',
                  });
              }
          },
          error: function (xhr) {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to update coin. Please try again.',
              });
          },
      });
    });
  });
</script> 
@endsection
