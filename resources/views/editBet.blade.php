@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Bet</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">EditBet</h6>
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
      <div class="page-header min-height-150 border-radius-xl" style="background-image: url('../../../img/curved-images/curved0.jpg'); background-position-y: 50%;">
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
              <h5 class="mb-1"> Edit Bet </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4 fit-content-body">
      <form class="multisteps-form__form">
        <div class="row">        
          <div class="col-12 col-lg-8 m-auto">          
              <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                <h5 class="font-weight-bolder">Please edit bet data now.</h5>
                <div class="multisteps-form__content">
                  <div class="row mt-3">
                    <div class="col-12 col-sm-6">
                      <label>Name</label>                      
                      <select name="choices-name" id="choices-name">     
                        <option value="" disabled selected>-- Select Name --</option>                        
                      </select>
                    </div>
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                      <label>Slip</label>
                      <input class="multisteps-form__input form-control" type="text" name="slip" placeholder="Slip" value="{{$active_json_data['slip']}}">
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-12 col-sm-6">
                      <label>ODDs</label>
                      <input class="multisteps-form__input form-control" type="text" name="odds" placeholder="Enter odds" value="{{$active_json_data['odds']}}">
                    </div>
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                      <label>Amount</label>
                      <input class="multisteps-form__input form-control" type="text" name="amount" placeholder="Enter amount" value="{{$active_json_data['amount']}}">
                    </div>
                  </div>
                  <div class="row mt-3">                    
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0 d-flex align-items-center justify-content-between d-flex flex-column">
                      <div class="w-100">
                        <label>Current Type</label>
                        <select name="choices-currency-type" id="choices-currency-type">
                          <option value="a-(applepay)" {{$active_json_data['currency'] == "a-(applepay)"?'selected':''}}>A-(APPLEPAY)</option>
                          <option value="b-(bitcoin)" {{$active_json_data['currency'] == "b-(bitcoin)"?'selected':''}}>B-(BITCOIN)</option>
                          <option value="e-(ethereum)" {{$active_json_data['currency'] == "e-(ethereum)"?'selected':''}}>E-(ETHEREUM)</option>
                          <option value="u-(ukbt)" {{$active_json_data['currency'] == "u-(ukbt)"?'selected':''}}>U-(UKBT)</option>
                          <option value="c-(CAD)" {{$active_json_data['currency'] == "c-(CAD)"?'selected':''}}>C-(CAD)</option>
                          <option value="m-(OSRS)" {{$active_json_data['currency'] == "m-(OSRS)"?'selected':''}}>M-(OSRS)</option>
                          <option value="r-(RS3)" {{$active_json_data['currency'] == "r-(RS3)"?'selected':''}}>R-(RS3)</option>
                        </select>                        
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                      <label>Note</label>
                      <textarea class="form-control" type="text" name="note" placeholder="Enter note" rows="3">{{$active_json_data['notes']}}</textarea>
                    </div>
                  </div>
                  <div class="row mt-3">                                      
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0 d-flex align-items-center justify-content-start mb-0">                                            
                      <label class="text-sm m-0">Splitters</label>
                      <div class="form-check form-switch ms-3 c-add-btn">
                        <i class="ni ni-fat-add me-1" aria-hidden="true"></i>
                      </div>
                    </div>
                    <div id="dynamic-fields-container">
                                          
                    </div>
                  </div>
                  <div class="button-row d-flex mt-4 d-flex align-items-center justify-content-center">
                    <button class="btn bg-gradient-primary js-btn-next" type="button" title="Next">Register</button>
                  </div>
                </div>
              </div>                      
          </div>
        </div>    
      </form>  
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@parent
<script src="{{ asset('js/plugins/choices.min.js') }}"></script>       
<script>
    $(document).ready(function () {
      let fieldCounter = 0;
      if (document.getElementById('choices-currency-type')) {      
        var element = document.getElementById('choices-currency-type');
        const currency_type = new Choices(element, {
          searchEnabled: false
        });      
      };
      let bet_id = {{ $bet_id }};
      // Load select box data and preselect values if provided
      function loadSelectBoxData(selectId, useCustomers, preselectedValue = null) {
          $.ajax({
              type: 'GET',
              url: '{{ route("customer_splitter_data") }}', // Replace with your route name
              success: function (response) {
                  const selectBox = document.getElementById(selectId);
                  const data = useCustomers ? response.customers : response.hosts;
  
                  data.forEach((item) => {
                      const option = document.createElement('option');
                      option.value = item.id;
                      option.textContent = item.name;
  
                      if (preselectedValue && item.id == preselectedValue) {
                          option.selected = true; // Preselect the option
                      }
  
                      selectBox.appendChild(option);
                  });
  
                  // Initialize the Choices.js plugin after populating options
                  setTimeout(() => {
                      new Choices(`#${selectId}`, {
                          removeItemButton: true,
                          searchEnabled: true,
                          searchChoices: true,
                          searchFocus: true,
                      });
                  }, 100);
              },
              error: function () {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'Failed to load data for the select box.',
                  });
              },
          });
      }
  
      // Initialize customer data for the main select box
      const mainCustomerId = '{{ $customerId }}';
      loadSelectBoxData("choices-name", true, mainCustomerId);
  
      // Initialize existing splitters with preselected values
      const existingSplitters = @json($active_json_data['arrSplitters']);
      existingSplitters.forEach((splitter, index) => {
          addSplitterField(splitter.customer_id, splitter.amount);
      });
  
      // Add dynamic field with optional preselected values
      function addSplitterField(preselectedCustomerId = null, preselectedAmount = null) {
          const selectId = `choices-name-${fieldCounter}`;
          const fieldHTML = `
              <div class="dynamic-field mt-2">
                  <div class="row">
                      <div class="col-5">
                          <label>Name</label>
                          <select id="${selectId}" name="choices-name[]" class="form-control choices-plugin">
                              <option value="" disabled>-- Select Name --</option>
                          </select>
                      </div>
                      <div class="col-5">
                          <label>Amount</label>
                          <input type="text" name="amount[]" class="form-control" placeholder="Enter amount" value="${preselectedAmount || ''}">
                      </div>
                      <div class="col-2 d-flex justify-content-center align-items-end">
                          <button type="button" class="btn btn-danger btn-sm m-0 remove-field">Remove</button>
                      </div>
                  </div>
              </div>
          `;
  
          $('#dynamic-fields-container').append(fieldHTML);
          loadSelectBoxData(selectId, false, preselectedCustomerId);
          fieldCounter++;
      }
  
      // Add new dynamic field on button click
      $(document).on('click', '.c-add-btn', function () {
          addSplitterField();
      });
  
      // Remove dynamic field
      $(document).on('click', '.remove-field', function () {
          $(this).closest('.dynamic-field').remove();
      });
  
      // Submit form data
      $(document).on('click', '.js-btn-next', function () {
          const slip = $('input[name="slip"]').val();
          const odds = $('input[name="odds"]').val();
          const amount = $('input[name="amount"]').val();
          const currency = $('#choices-currency-type').val();
          const note = $('textarea[name="note"]').val();
          const customer_id = $('#choices-name').val();
  
          const splitters = [];
          $('#dynamic-fields-container .dynamic-field').each(function () {
              const splitter_id = $(this).find('select[name="choices-name[]"]').val();
              const amount = $(this).find('input[name="amount[]"]').val();
  
              if (splitter_id && amount) {
                  splitters.push({
                      customer_id: splitter_id,
                      amount: amount,
                  });
              }
          });
  
          // Validate required fields
          if (!slip || !odds || !amount || !currency) {
              Swal.fire({
                  icon: 'error',
                  title: 'Validation Error',
                  text: 'Please fill in all required fields.',
              });
              return;
          }
  
          // Confirmation prompt
          Swal.fire({
              title: 'Are you sure?',
              text: 'You are about to register a new bet.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, register it!',
              cancelButtonText: 'Cancel',
          }).then((result) => {
              if (result.isConfirmed) {
                  // AJAX request to store the bet
                  $.ajax({
                      type: 'POST',                                            
                      url: `/all_bets/${bet_id}/singleBet/update`,                                          
                      data: {
                          slip: slip,
                          odds: odds,
                          amount: amount,
                          currency: currency,
                          note: note,
                          updatedArrSplitters: splitters,
                          customerID: customer_id,
                          status: 3,
                          _token: "{{ csrf_token() }}",
                      },
                      success: function (response) {
                          if (response.status) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Success!',
                                  text: response.message,
                                  confirmButtonText: 'OK',
                              }).then(() => {
                                  window.location.href = '{{ route("dashboard") }}';
                              });
                          } else {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Error!',
                                  text: response.message,
                              });
                          }
                      },
                      error: function (xhr) {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: xhr.responseJSON?.message || 'An unexpected error occurred.',
                          });
                      },
                  });
              }
          });
      });
    });
  </script>
@endsection
