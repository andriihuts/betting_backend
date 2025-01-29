@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tabs</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Tabs</h6>
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
              <h5 class="mb-1"> Tabs </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4 pt-0 fit-content-body">
      <div class="row">
          <div class="col-lg-12 m-auto mb-lg-0 mb-4">
              <div class="card mt-4" id="accounts">
                  <div class="card-body pt-2 pb-1 tab-container">
                      <div class="ps-5 ms-3">
                          <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                              <p class="text-sm font-weight-bold my-auto ps-sm-2">Enter Host</p>
                              <input id="host_name" class="form-control form-control-sm ms-sm-auto mt-sm-0 mt-2 w-40 c-mt-2" type="text" value=""
                                  data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Input the host name!"
                                  data-bs-original-title="Input the host name!">
                              <button id="btn_add_host" class="btn btn-sm bg-gradient-primary my-sm-auto mt-2 mb-0" type="button">
                                  <i class="fas fa-plus me-2"></i>Add
                              </button>
                          </div>
                      </div>
                      <div id="host_items">
                          @foreach ($hosts as $host)
                              <div class="d-flex mt-3 host-item" id="host_{{$host['id']}}">
                                  <div class="my-auto ms-3">
                                      <div class="h-100 d-flex align-items-center">
                                          <div>
                                              <h6 class="mb-0">{{$host['name']}}</h6>
                                              <p class="mb-0 text-sm">{{$host['total_perfect']}}$ | {{$host['total_game']}} m | {{$host['total_cad']}} c | {{$host['total_rs3']}} RS3</p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ms-auto text-end">
                                      <a class="btn text-dark text-gradient px-3 mb-0 btn_edit"
                                        href="javascript:;" data-id="{{ $host['id'] }}" data-name="{{ $host['name'] }}">
                                          <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>Edit
                                      </a>
                                      <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete"
                                        href="javascript:;" data-name="{{$host['name']}}" data-flag="0">
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
    <div class="modal fade" id="tabModalMessage" tabindex="-1" aria-labelledby="tabModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tabModalLabel">Update Tab</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <input type="hidden" id="host_id" name="id">
                        @foreach (['a_apply_pay' => 'a(ApplePay)', 'b(b_bitcoin)' => 'Bitcoin', 'e(e_ethereum)' => 'Ethereum', 'c_card' => 'c(CAD)', 'u_usdt' => 'u(USDT)', 'm_game_currency' => 'm(OSRS)', 'r_rs3' => 'r(RS3)'] as $key => $label)
                            <div class="row">
                                <div class="col-md-2 mr-1">
                                    <label class="col-form-label c-font-size-12">{{ $label }}:</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" class="form-control form-control-alternative" id="{{ $key }}1" name="{{ $key }}1" placeholder="Empty">
                                </div>
                                <div class="col-md-5">
                                    <input type="number" class="form-control form-control-alternative" id="{{ $key }}2" name="{{ $key }}2" value="">
                                </div>
                            </div>
                        @endforeach
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
    $('#btn_add_host').on('click', function () {
        const hostName = $('#host_name').val().trim();

        if (!hostName) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Host name cannot be empty!',
                confirmButtonText: 'OK',
            });
            return;
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("customer_store") }}', // Shared API for customer and host
            data: {
                name: hostName,
                flag: 0, // 0 for host
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.status === true) {
                    // Add the new host to the list
                    $('#host_items').append(`
                        <div class="d-flex mt-3 host-item" id="host_${response.customer.id}">
                            <div class="my-auto ms-3">
                                <div class="h-100 d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0">${hostName}</h6>
                                        <p class="mb-0 text-sm">0$ | 0 m | 0 c | 0 RS3</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <a class="btn text-dark text-gradient px-3 mb-0 btn_edit"
                                    href="javascript:;" data-id="${response.customer.id}" data-name="${hostName}">
                                        <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>Edit
                                </a>
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete"
                                   href="javascript:;" data-name="${hostName}" data-flag="0">
                                    <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete
                                </a>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                    `);

                    // Clear the input field
                    $('#host_name').val('');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Host added successfully!',
                        confirmButtonText: 'OK',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to add host.',
                        confirmButtonText: 'OK',
                    });
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add host. Please try again.',
                    confirmButtonText: 'OK',
                });
            },
        });
    });

    // Delete Host
    $(document).on('click', '.btn_delete', function () {
        const hostName = $(this).data('name');
        const hostFlag = $(this).data('flag');

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete the host "${hostName}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("customer_destory") }}', // Shared API for customer and host
                    data: {
                        name: hostName,
                        flag: hostFlag, // 0 for host
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.status === true) {
                            // Remove the host from the DOM
                            $(`.btn_delete[data-name="${hostName}"]`).closest('.host-item').fadeOut('slow', function () {
                                $(this).remove();
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: `Host "${hostName}" removed successfully.`,
                                confirmButtonText: 'OK',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to remove host.',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to remove host. Please try again.',
                            confirmButtonText: 'OK',
                        });
                    },
                });
            }
        });
    });

    $(document).on('click', '.btn_edit', function () {
      const hostId = $(this).data('id');
      const hostName = $(this).data('name');

       // Fetch customer data via API
       $.ajax({
          type: 'GET',
          url: `/customers/${hostId}`,
          success: function (response) {
              if (response.status === true) {
                  const customer = response.single;

                  // Populate modal fields with customer data
                  $('#host_id').val(hostId);
                  $('#tabModalLabel').text(`Update Tab for ${customer.name}`);

                  // Populate the input fields dynamically
                  Object.keys(customer).forEach((key) => {
                    if(key.endsWith('1') && customer[key] == 0){
                        $(`#${key}`).val("");
                    }else if(key.endsWith('2') && customer[key] == 0){
                        $(`#${key}`).val("");
                    }else{
                        $(`#${key}`).val(customer[key]);
                    }
                  });

                  // Show the modal
                  $('#tabModalMessage').modal('show');
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.message || 'Failed to fetch customer data.',
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
            id: $('#host_id').val(),
        };

        formData.forEach(field => {
            if (field.name.endsWith('1') || field.name.endsWith('2')) {
                const key = field.name.slice(0, -1); // Remove the numeric suffix
                data[key] = (data[key] || 0) + parseFloat(field.value || 0);
                if (field.name.endsWith('2')) {
                    data[`${key}_history`] = parseFloat(field.value || 0);
                }
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{ route("customer_update") }}',
            data: data,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Tab updated successfully!',
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update tab.',
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update tab. Please try again.',
                });
            },
        });
    });    
  });
</script> 
@endsection
