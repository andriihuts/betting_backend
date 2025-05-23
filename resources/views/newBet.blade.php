@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">New Bet</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">NewBet</h6>
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
              <h5 class="mb-1"> New Bet </h5>              
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
                <h5 class="font-weight-bolder">Please register new bets now.</h5>
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
                      <input class="multisteps-form__input form-control" type="text" name="slip" placeholder="Slip">
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-12 col-sm-6">
                      <label>ODDs</label>
                      <input class="multisteps-form__input form-control" type="text" name="odds" placeholder="Enter odds">
                    </div>
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                      <label>Amount</label>
                      <input class="multisteps-form__input form-control" type="text" name="amount" placeholder="Enter amount">
                    </div>
                  </div>
                  <div class="row mt-3">                    
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0 d-flex align-items-center justify-content-between d-flex flex-column">
                      <div class="w-100">
                        <label>Current Type</label>
                        <select name="choices-currency-type" id="choices-currency-type">
                          <option value="a-(applepay)">A-(APPLEPAY)</option>
                          <option value="b-(bitcoin)">B-(BITCOIN)</option>
                          <option value="e-(ethereum)">E-(ETHEREUM)</option>
                          <option value="u-(ukbt)">U-(UKBT)</option>
                          <option value="c-(CAD)">C-(CAD)</option>
                          <option value="m-(OSRS)">M-(OSRS)</option>
                          <option value="r-(RS3)">R-(RS3)</option>
                        </select>                        
                      </div>
                    </div>                    
                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                      <label>Note</label>
                      <textarea class="form-control" type="text" name="note" id="note" placeholder="Enter note" rows="3"></textarea>
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
  // JavaScript code
  $(document).ready(function () {
    let fieldCounter = 0;
    if (document.getElementById('choices-currency-type')) {      
        var element = document.getElementById('choices-currency-type');
        const currency_type = new Choices(element, {
          searchEnabled: false
        });      
      };
    // Load data for select box
    function loadSelectBoxData(selectId = "choices-name", useCustomers = true) {
        $.ajax({
            type: 'GET',
            url: '{{ route("customer_splitter_data") }}', // Replace with your route name
            success: function (response) {
                const selectBox = document.getElementById(selectId);                
                const data = useCustomers ? response.customers : response.hosts;

                localStorage.setItem('customers', JSON.stringify(response.customers))
                localStorage.setItem('hosts', JSON.stringify(response.hosts))

                data.forEach((item) => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectBox.appendChild(option);
                });                
                // Delay the initialization of the Choices plugin
                setTimeout(function () {                  
                    const element = document.getElementById(selectId);
                    // console.log('select box here2222', element);
                    new Choices(element, {
                        removeItemButton: false,
                        searchEnabled: true,
                        searchChoices: true,
                        searchFocus: true,
                    });
                    // Manually focus on the search input when the dropdown opens
                    element.addEventListener('showDropdown', () => {
                      setTimeout(() => {
                          const searchInput = element.parentNode.parentNode.querySelector('.choices__list input');
                          if (searchInput) {
                              searchInput.focus();
                          }
                      }, 100);
                    });
                }, 100); // Delay for 100ms to ensure the DOM is updated
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
    loadSelectBoxData("choices-name", true);

    // Add dynamic fields on button click
    $(document).on('click', '.c-add-btn', function () {
        const selectId = `choices-name-${fieldCounter}`;
        const fieldHTML = `
            <div class="dynamic-field mt-2">
                <div class="row">
                    <div class="col-5">
                        <label>Name</label>
                        <select id="${selectId}" name="choices-name[]" class="form-control choices-plugin">
                            <option value="" disabled selected>-- Select Name --</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <label>Amount</label>
                        <input type="text" name="amount[]" class="form-control" placeholder="Enter amount">
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-end">
                      <button type="button" class="btn btn-danger btn-sm m-0 remove-field">Remove</button>
                    </div>
                </div>
                
            </div>
        `;
        $('#dynamic-fields-container').append(fieldHTML);

        // Load host data for dynamically added select box
        // loadSelectBoxData(selectId, false);

        const selectBox = document.getElementById(selectId);
        
        const data = JSON.parse(localStorage.getItem('hosts'))

        data.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            selectBox.appendChild(option);
        });                
        // Delay the initialization of the Choices plugin
        setTimeout(function () {                  
            const element = document.getElementById(selectId);
            new Choices(element, {
                removeItemButton: false,
                searchEnabled: true,
                searchChoices: true,
                searchFocus: true,
            });
            // Manually focus on the search input when the dropdown opens
            element.addEventListener('showDropdown', () => {
              setTimeout(() => {
                  const searchInput = element.parentNode.parentNode.querySelector('.choices__list input');
                  if (searchInput) {
                      searchInput.focus();
                  }
              }, 100);
            });
        }, 100); // Delay for 100ms to ensure the DOM is updated
        
        fieldCounter++;
    });

    // Remove dynamic field
    $(document).on('click', '.remove-field', function () {
        $(this).closest('.dynamic-field').remove();
    });

    // Collect form data and submit
    $(document).on('click', '.js-btn-next', function () {
        const slip = $('input[name="slip"]').val();
        const odds = $('input[name="odds"]').val();
        const amount = $('input[name="amount"]').val();
        const currency = $('#choices-currency-type').val();
        const note = $('textarea[name="note"]').val();
        const customer_id = $('#choices-name').val();

        // Collect dynamic fields (splitters)
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
        console.log('splitters datae', splitters);
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
                    url: '{{ route("bet_store") }}', // Replace with your route name
                    data: {
                        slip: slip,
                        odds: odds,
                        amount: amount,
                        currency: currency,
                        notes: note,
                        splitters1: splitters,
                        customer_id: customer_id,
                        status: 3,
                        live: 1,
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
