@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Websites</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Websites</h6>
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
              <h5 class="mb-1"> Useful Websites </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>

    <div class="container-fluid py-4 fit-content-body">      
      <div class="row gx-4 mt-4">                 
        <div class="col-md-12 m-auto r_rate_box">
        <div class="card mt-4" id="websites">
            <div class="card-body pt-2 pb-1 tab-container">
                <div class="ps-5 ms-3">
                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2">
                        <p class="text-sm font-weight-bold my-auto ps-sm-2">Enter Website</p>
                        <input id="website_name" class="form-control form-control-sm ms-sm-auto mt-sm-0 mt-2 w-40 c-mt-2" type="text" value=""
                            data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Input the website name!"
                            data-bs-original-title="Input the website name!">
                        <button id="btn_add_website" class="btn btn-sm bg-gradient-primary my-sm-auto mt-2 mb-0" type="button">
                            <i class="fas fa-plus me-2"></i>Add
                        </button>
                    </div>
                </div>
                <div id="website_items">
                    @foreach ($all_websites as $website)
                        <div class="d-flex mt-3 website-item" id="website_{{$website['id']}}" data-id="{{ $website['id'] }}" data-name="{{ $website['name'] }}">
                            <div class="my-auto ms-3">
                                <div class="h-100 d-flex align-items-center gap-3">
                                    <div>
                                        <img src="{{$website['icon_url']}}" width="40" height="40" />
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{$website['name']}}</h6>
                                        <p class="mb-0">{{$website['website_url']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <a class="btn text-dark text-gradient px-3 mb-0 btn_edit"
                                  href="javascript:;" data-id="{{ $website['id'] }}" data-name="{{ $website['name'] }}">
                                    <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>Edit
                                </a>
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete"
                                  href="javascript:;" data-name="{{$website['name']}}" data-flag="0">
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
    <div class="modal fade" id="websiteModalMessage" tabindex="-1" aria-labelledby="websiteModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="websiteModalLabel">Update Website</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <input type="hidden" id="website_id" name="id">
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
                                <label class="col-form-label c-font-size-12">Website URL:</label>
                            </div>
                            <div class="col-md-9 my-2">
                                <input type="text" class="form-control form-control-alternative" id="website_url" name="website_url" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <label class="col-form-label c-font-size-12">Icon URL:</label>
                            </div>
                            <div class="col-md-9 my-2">
                                <input type="file" class="form-control form-control-alternative" id="file" name="file" required>
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
    $('#btn_add_website').on('click', function () {
      const websiteName = $('#website_name').val().trim();

      if (!websiteName) {
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Website name cannot be empty!',
              confirmButtonText: 'OK',
          });
          return;
      }

      $.ajax({
          type: 'POST',
          url: '{{ route("website_store") }}', // Shared API for website
          data: {
              name: websiteName,
              _token: '{{ csrf_token() }}',
          },
          success: function (response) {
              if (response.status === true) {
                  // Add the new website to the list
                  $('#website_items').append(`
                      <div class="d-flex mt-3 website-item" id="website_${response.website.id}" data-id="${response.website.id}" data-name="${websiteName}">
                          <div class="my-auto ms-3">
                              <div class="h-100 d-flex align-items-center gap-3">
                                  <div>
                                    <img src="${response.website.iconurl}" width="40" height="40" />
                                  </div>
                                  <div>
                                      <h6 class="mb-0">${websiteName}</h6>
                                      <p>${response.website.address}</p>
                                  </div>
                              </div>
                          </div>
                          <div class="ms-auto text-end">
                            <a class="btn text-dark text-gradient px-3 mb-0 btn_edit"
                                  href="javascript:;" data-id="${response.website.id}" data-name="${websiteName}">
                                    <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>Edit
                            </a>
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn_delete"
                                href="javascript:;" data-name="${websiteName}">
                                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete
                            </a>
                          </div>
                      </div>
                      <hr class="horizontal dark">
                  `);

                  // Clear the input field
                  $('#website_name').val('');

                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Website added successfully!',
                      confirmButtonText: 'OK',
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.message || 'Failed to add website.',
                      confirmButtonText: 'OK',
                  });
              }
          },
          error: function (xhr) {
              console.error('Error:', xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to add website. Please try again.',
                  confirmButtonText: 'OK',
              });
          },
      });
    });

    // Delete Website
    $(document).on('click', '.btn_delete', function () {
      const websiteName = $(this).data('name');

      Swal.fire({
          title: 'Are you sure?',
          text: `You are about to delete the website "${websiteName}".`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel',
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  type: 'POST',
                  url: '{{ route("website_destory") }}', // Shared API for customer and website
                  data: {
                      name: websiteName,
                      _token: '{{ csrf_token() }}',
                  },
                  success: function (response) {
                      if (response.status === true) {
                          // Remove the website from the DOM
                          $(`.btn_delete[data-name="${websiteName}"]`).closest('.website-item').fadeOut('slow', function () {
                              $(this).remove();
                          });

                          Swal.fire({
                              icon: 'success',
                              title: 'Deleted!',
                              text: `website "${websiteName}" removed successfully.`,
                              confirmButtonText: 'OK',
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: response.message || 'Failed to remove website.',
                              confirmButtonText: 'OK',
                          });
                      }
                  },
                  error: function (xhr) {
                      console.error('Error:', xhr.responseText);
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Failed to remove website. Please try again.',
                          confirmButtonText: 'OK',
                      });
                  },
              });
          }
      });
    });

    $(document).on('click', '.btn_edit', function () {
      const websiteId = $(this).data('id');
      const websiteName = $(this).data('name');

      // Fetch customer data via API
      $.ajax({
        type: 'GET',
        url: `/websites/${websiteId}`,
        success: function (response) {
            if (response.status === true) {
                const website = response.single;

                // Populate modal fields with customer data
                $('#website_id').val(websiteId);
                $('#websiteModalLabel').text(`Update Website for ${website.name}`);

                // Populate the input fields dynamically
                Object.keys(website).forEach((key) => {
                    if(key !== 'icon_url'){
                        $(`#${key}`).val(website[key]);
                    }
                });

                // Show the modal
                $('#websiteModalMessage').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch website data.',
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

    $(document).on('click', '.website-item', function () {
        // Prevent event from firing when clicking on .btn-delete
        if ($(event.target).closest('.btn_delete').length) {
            return;
        }
        
      const websiteId = $(this).data('id');
      const websiteName = $(this).data('name');

      // Fetch customer data via API
      $.ajax({
        type: 'GET',
        url: `/websites/${websiteId}`,
        success: function (response) {
            if (response.status === true) {
                const website = response.single;

                // Populate modal fields with customer data
                $('#website_id').val(websiteId);
                $('#websiteModalLabel').text(`Update Website for ${website.name}`);

                // Populate the input fields dynamically
                Object.keys(website).forEach((key) => {
                    if(key !== 'icon_url'){
                        $(`#${key}`).val(website[key]);
                    }
                });

                // Show the modal
                $('#websiteModalMessage').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch website data.',
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

        const formData = new FormData();
        formData.append('file', $('#file')[0].files[0])
        $.ajax({
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{ route("upload") }}', // Shared API for website
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response.status === true) {
                    update_useful_website(response.file_path)
                } else {
                    update_useful_website()
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Error',
                    //     text: response.message || 'Failed to upload icon file.',
                    //     confirmButtonText: 'OK',
                    // });
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                update_useful_website()
                // Swal.fire({
                //     icon: 'error',
                //     title: 'Error',
                //     text: 'Failed to upload icon file. Please try again.',
                //     confirmButtonText: 'OK',
                // });
            },
        });

    });
  });

  function update_useful_website(file_path = ''){    

    const data = {
          id: $('#website_id').val(),
          name: $('#name').val(),
          website_url: $('#website_url').val(),
          icon_url: file_path,
      };

      $.ajax({
          type: 'POST',
          url: '{{ route("website_update") }}',
          data: data,
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          success: function (response) {
              if (response.status === true) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Website updated successfully!',
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.message || 'Failed to update website.',
                  });
              }
          },
          error: function (xhr) {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to update website. Please try again.',
              });
          },
      });
  }
</script> 
@endsection
