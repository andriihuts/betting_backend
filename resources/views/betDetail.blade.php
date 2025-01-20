@extends('layouts.frontend')
@section('content')
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Active Bet</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Active Bet Details</li>
      </ol>          
      <h6 class="mb-1 text-gradient text-primary font-weight-bolder">Active Bet Details</h6>
    </nav>
  </div>
</nav>
<div class="container-fluid">
  <div class="page-header min-height-150 border-radius-xl" style="background-image: url('../../../img/curved-images/curved0.jpg'); background-position-y: 50%;">
    <span class="mask bg-gradient-primary opacity-6"></span>
  </div>
  <div class="card card-body blur shadow-blur mx-4 mt-n7 overflow-hidden">
    <div class="row gx-4">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src="{{ asset('img/small-logos/icon-sun-cloud.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1"> Active Bet Detail </h5>              
        </div>
      </div>          
    </div>
  </div>
</div>
<!-- End Navbar -->
<div class="container-fluid py-4 fit-content-body">
  <div class="row">        
    <div class="col-lg-8 m-auto">
      <div class="card mt-4 pt-3" id="notifications">            
        <div class="card-body pt-0">
          <div class="row">
            <div class="col-lg-12 m-auto">
              <div class="table-responsive">
                <table class="table mb-0">                  
                  <tbody>
                    <tr>
                      <td class="ps-1" colspan="4">
                        <div class="my-auto">
                          <h4 class="text-dark d-block text-sm">Name</h4>                          
                        </div>
                      </td>
                      <td>
                        <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                          <span class="badge badge-success badge-sm my-auto ms-auto me-3">{{$active_json_data['customer_name']}}</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="ps-1" colspan="4">
                        <div class="my-auto">
                          <h4 class="text-dark d-block text-sm">Slip</h4>                          
                        </div>
                      </td>
                      <td>
                        <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                          <span class="badge badge-success badge-sm my-auto ms-auto me-3">{{$active_json_data['slip']}}</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="ps-1" colspan="4">
                        <div class="my-auto">
                          <h4 class="text-dark d-block text-sm">Amount</h4>                          
                        </div>
                      </td>
                      <td>
                        <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                          <span class="badge badge-success badge-sm my-auto ms-auto me-3">${{$active_json_data['amount']}}</span>
                        </div>
                      </td>                      
                    </tr>
                    <tr>
                      <td class="ps-1" colspan="4">
                        <div class="my-auto">
                          <h4 class="text-dark d-block text-sm">currency</h4>                          
                        </div>
                      </td>
                      <td>
                        <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                          <span class="badge badge-success badge-sm my-auto ms-auto me-3">{{$active_json_data['currency']}}</span>
                        </div>
                      </td>                      
                    </tr>
                    <tr>
                      <td class="ps-1" colspan="4">
                        <div class="my-auto">
                          <h4 class="text-dark d-block text-sm">Odds</h4>                          
                        </div>
                      </td>
                      <td>
                        <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                          <span class="badge badge-success badge-sm my-auto ms-auto me-3">{{$active_json_data['odds']}}</span>
                        </div>
                      </td>                                           
                    </tr>
                    <tr>
                      <td class="ps-1" colspan="4">
                        <div class="my-auto">
                          <h4 class="text-dark d-block text-sm">Note</h4>                          
                        </div>
                      </td>
                      <td>
                        <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                          <span class="badge badge-success badge-sm my-auto ms-auto me-3">{{$active_json_data['notes']}}</span>
                        </div>
                      </td>                                           
                    </tr>
                  </tbody>
                </table>                
              </div>
              <h5 class="pt-3">Splitters Users</h5>
              <p class="text-sm">You can see the detailed splitter users information here.</p>
              <div class="table-responsive">
                <table class="table mb-0">                 
                  <tbody>
                    @foreach ($active_json_data['arrSplitters'] as $splitter)    
                      <tr>
                        <td class="ps-1" colspan="4">
                          <div class="my-auto">
                            <h4 class="text-dark d-block text-sm">{{$splitter['name']}}</h4>                          
                          </div>
                        </td>
                        <td>
                          <div class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                            <span class="badge badge-success badge-sm my-auto ms-auto me-3">${{$splitter['amount']}}</span>
                          </div>
                        </td>
                      </tr> 
                    @endforeach                        
                </table>
              </div>
            </div>                
          </div>                            
          <div class="row">
            <div class="col-lg-12">
              <div class="button-row d-flex mt-4 justify-content-center">
                <div>
                  <button class="btn bg-gradient-primary mt-4ght mb-0 js-btn-prev btn_win" type="button" title="Prev">win</button>
                  <button class="btn bg-gradient-warning mb-0 js-btn-prev btn_void" type="button" title="Prev">void</button>
                  <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next btn_lose" type="button" title="Next">Lose</button>
                </div>
              </div>
            </div>
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
      // Event handlers for Win, Lose, and Void buttons
      $('.btn_win, .btn_lose, .btn_void').on('click', function () {
          const betId = "{{$active_json_data['id']}}";
          let status;

          // Determine the status based on the clicked button
          if ($(this).hasClass('btn_win')) {
              status = 1; // Win
          } else if ($(this).hasClass('btn_lose')) {
              status = 0; // Lose
          } else if ($(this).hasClass('btn_void')) {
              status = 2; // Void (if applicable, otherwise use an appropriate flag)
          }

          // Confirmation prompt 
          Swal.fire({
              title: 'Are you sure?',
              text: `You are about to update the bet status to "${$(this).text()}".`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, update it!',
              cancelButtonText: 'Cancel',
          }).then((result) => {
              if (result.isConfirmed) {
                  // AJAX request to update the bet status
                  $.ajax({
                      type: 'POST',
                      url: `{{ route('bet_update_status', ':type') }}`.replace(':type', betId),
                      data: {
                          status: status,
                          _token: "{{ csrf_token() }}",
                      },
                      success: function (response) {
                          if (response.status === true) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Success!',
                                  text: 'The bet status has been updated.',
                                  confirmButtonText: 'OK',
                              }).then(() => {
                                  // Reload the page or update UI as needed
                                  window.location.href = "{{ route('dashboard') }}";
                              });
                          } else {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Error!',
                                  text: response.message || 'Failed to update the bet status.',
                                  confirmButtonText: 'OK',
                              });
                          }
                      },
                      error: function (xhr) {
                        console.log('xhr heree', xhr);
                          Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: 'Something went wrong. Please try again.',
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
