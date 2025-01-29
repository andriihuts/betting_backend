@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">MISC</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">MISC</h6>
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
              <h5 class="mb-1"> MISC </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4 fit-content-body">      
      <div class="row gx-4 mt-4">
        <div class="col-md-6 m-auto">
          <div class="card">
            <div class="card-header p-3 pb-0">
              <h6 class="mb-1">MISC Settings</h6>
              <p class="text-sm mb-0">Please write the amount and select currency.</p>
            </div>
            <div class="card-body p-3 misc_form_box">              
              <form action="#">
                <label class="form-label">Enter amount</label>
                <div class="form-group">
                  <input class="form-control" type="number" placeholder="Enter amount">
                </div>                   
                <div class="form-group d-flex align-items-center justify-content-between">
                  <span class="text-sm">Currency - $</span>
                  <div class="form-check form-switch ms-3">
                    <input class="form-check-input" type="radio" id="d_currency" checked name="currency_type">
                  </div>
                </div>
                <div class="form-group d-flex align-items-center justify-content-between">
                  <span class="text-sm">Currency - M</span>
                  <div class="form-check form-switch ms-3">
                    <input class="form-check-input" type="radio" id="m_currency" name="currency_type">
                  </div>
                </div>
                <div class="form-group d-flex align-items-center justify-content-between">
                  <span class="text-sm">Currency - RS3</span>
                  <div class="form-check form-switch ms-3">
                    <input class="form-check-input" type="radio" id="r_currency" name="currency_type">
                  </div>
                </div>
                <button class="btn bg-gradient-primary w-100 mb-0" id="set_amount">Set Amount for Misc</button>
              </form>
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
    // Handle button click for setting amount and currency
    $(document).on('click', '#set_amount', function (e) {
        e.preventDefault();                
        const amount = $('input[type="number"]').val();
        const moneyType = $('input[name="currency_type"]:checked').attr('id');
        
        // Validate amount
        if (!amount || isNaN(amount)) {
            alert('Please enter a valid amount.');
            return;
        }
                
        let moneyTypeValue = 0; // Default to 0 for $ (default currency)
        if (moneyType === "m_currency") {
            moneyTypeValue = 2; // Game money (M)
        } else if (moneyType === "r_currency") {
            moneyTypeValue = 3; // RS3 money (RS3)
        }              
        updateAmountAndCurrency(amount, moneyTypeValue);
    });
});

// Update amount and currency type in backend  
function updateAmountAndCurrency(amount, moneyType) {    
    const csrfToken = '{{ csrf_token() }}';
    
    // Show loading spinner or similar feedback
    const rateForm = $(document).find('.misc_form_box');
    rateForm.addClass('loading');
        
    $.post(
        `{{ route('payment_store_misc') }}`,
        {
            amount: amount,
            money_type: moneyType,
            _token: csrfToken
        },
        function (data, status) {
            if (data.status) {
                console.log('Data posted successfully', data, status);
                rateForm.removeClass('loading');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Amount has been saved successfully!',
                    confirmButtonText: 'OK',
                });
            } else {
                rateForm.removeClass('loading');
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
        rateForm.removeClass('loading');
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
