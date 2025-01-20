@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Currency</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Currency</h6>
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
              <h5 class="mb-1"> Setting Currency </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4 fit-content-body">      
      <div class="row gx-4 mt-4">
        <div class="col-md-4 m-auto m_rate_box">
          <div class="card">
            <div class="card-header p-3 pb-0">
              <h6 class="mb-1">M Rate Setting</h6>
              <p class="text-sm mb-0">Please specify the value of M.</p>
            </div>
            <div class="card-body p-3">              
                <label class="form-label">Enter amount</label>
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Enter amount" id="m_rate" value="{{$m_rate}}">
                </div>                                   
                <button class="btn bg-gradient-primary w-100 mb-0" id="update_m_rate">Currency M Rate</button>
            </div>
          </div>
        </div>                    
        <div class="col-md-4 m-auto r_rate_box">
          <div class="card">
            <div class="card-header p-3 pb-0">
              <h6 class="mb-1">RS3 Rate Setting</h6>
              <p class="text-sm mb-0">Please specify the value of RS3.</p>
            </div>
            <div class="card-body p-3">              
                <label class="form-label">Enter amount</label>
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Enter amount" id="r_rate"  value="{{$r_rate}}">
                </div>                                   
                <button class="btn bg-gradient-primary w-100 mb-0" id="update_r_rate">Currency RS3 Rate</button>
            </div>
          </div>
        </div>                 
      </div>
    </div>
@endsection
@section('scripts')
@parent  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>        
    $(document).ready(function () {
        // Fetch current currency rates on page load            
        // Update M Rate
        $(document).off('click', '#update_m_rate').on('click', '#update_m_rate', function () {     
            const mRate = $('#m_rate').val();
            if (!mRate) {
                alert('Please enter a valid M rate.');
                return;
            }else{
              console.log('hey why calling me?1111');
              updateRate(1);
            }            
        });

        // Update RS3 Rate
        $(document).off('click', '#update_r_rate').on('click', '#update_r_rate', function () {     
            const rRate = $('#r_rate').val();
            if (!rRate) {
                alert('Please enter a valid RS3 rate.');
                return;
            }else{
              console.log('hey why calling me?222');
              updateRate(2);
            }            
        });
    });

    // Update currency rate  
    function updateRate(type) {
      // Get the CSRF token and rate input based on the type
      const csrfToken = '{{ csrf_token() }}';
      const rateInput = type === 1 ? $('#m_rate').val() : $('#r_rate').val();
      const dataKey = type === 1 ? 'm_rate' : 'r_rate';
      var rate_form;
      if(type === 1)
        rate_form = $(document).find('.m_rate_box');
      else
        rate_form = $(document).find('.r_rate_box');

      rate_form.addClass('loading');                       
      //Make the POST request
      $.post(
          `{{ route('currency_store_type', ':type') }}`.replace(':type', type),
          { [dataKey]: rateInput, _token: csrfToken },
          function (data, status) {
              if (data.status === 'success') {
                  console.log('data post', data, status);
                  rate_form.removeClass('loading');
                  Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Saved the data successfully!',
                    confirmButtonText: 'OK',
                  });
              } else {
                  rate_form.removeClass('loading');
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to save the data: ' + data.message,
                    confirmButtonText: 'OK',
                  });
              }
          }
      ).fail(function (xhr) {
          console.error('Error:', xhr.responseText);
          rate_form.removeClass('loading');
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to save the data. Please check the console for details.',
            confirmButtonText: 'OK',
          });
      });
    }
</script>
@endsection
