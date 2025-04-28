@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Customers</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Customers</h6>
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
              <h5 class="mb-1"> Customers </h5>              
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
              <!-- Input Section -->
              <div class="ps-5 ms-3">
                <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                  <p class="text-sm font-weight-bold my-auto ps-sm-2">Enter Customer name</p>
                  <input id="customer_name" class="form-control form-control-sm ms-sm-auto mt-sm-0 mt-2 w-40 c-mt-2" type="text"
                        placeholder="Input customer name">
                  <button id="btn_add_customer" class="btn btn-sm bg-gradient-primary my-sm-auto mt-2 mb-0" type="button">
                    <i class="fas fa-plus me-2"></i>Add
                  </button>
                </div>
              </div>

              <!-- Customer List -->
              <div id="customer_items">
                @foreach ($customers as $customer)
                  <div class="d-flex mt-3 customer-item" id="customer_{{$customer['name']}}">
                    <div class="my-auto ms-3">
                      <div class="h-100 d-flex align-items-center">
                        <div>
                          <h6 class="mb-0">{{$customer['name']}}</h6>
                          <p class="mb-0 text-md text-bold" style="color: {{$customer['total_perfect']>=0?'#008888':'#FF0000'}}">{{$customer['total_perfect']}}$ | {{$customer['total_game']}} m | 
                              {{$customer['total_cad']}} c | {{$customer['total_rs3']}} RS3</p>
                        </div>
                      </div>
                    </div>
                    <div class="ms-auto text-end">
                      <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete_customer" href="javascript:;" 
                        data-name="{{$customer['name']}}" data-flag="1">
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
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@parent 
<script>
  $(document).ready(function () {
    // Add Customer
    $('#btn_add_customer').on('click', function () {
        const customerName = $('#customer_name').val().trim();

        if (!customerName) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Customer name cannot be empty!',
                confirmButtonText: 'OK',
            });
            return;
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("customer_store") }}', // Replace with the correct route for adding customers
            data: {
                name: customerName,
                flag: 1, // Example flag, adjust as needed
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.status === true) {
                    // Add the new customer to the list
                    $('#customer_items').append(`
                        <div class="d-flex mt-3 customer-item" id="customer_${customerName}">
                            <div class="my-auto ms-3">
                                <div class="h-100 d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0">${customerName}</h6>
                                        <p class="mb-0 text-sm">0$ | 0 m | 0 c | 0 RS3</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete_customer" 
                                   href="javascript:;" data-name="${customerName}" data-flag="1">
                                    <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete
                                </a>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                    `);

                    // Clear the input field
                    $('#customer_name').val('');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Customer added successfully!',
                        confirmButtonText: 'OK',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to add customer.',
                        confirmButtonText: 'OK',
                    });
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add customer. Please try again.',
                    confirmButtonText: 'OK',
                });
            },
        });
    });

    // Delete Customer
    $(document).on('click', '.btn_delete_customer', function () {
        const customerName = $(this).data('name');
        const flag = $(this).data('flag');
      
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete customer "${customerName}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("customer_destory") }}',
                    data: {
                        name: customerName,
                        flag: flag,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                      console.log('response.status here', response.status);
                        if (response.status === true) {
                            // Remove the customer from the DOM
                            $(`#customer_${customerName}`).fadeOut('slow', function () {
                                $(this).remove();
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Customer removed successfully.',
                                confirmButtonText: 'OK',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to remove customer.',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to remove customer. Please try again.',
                            confirmButtonText: 'OK',
                        });
                    },
                });
            }
        });
    });
  });
</script>
@endsection
