@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Settled Bet</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Settled Bet</h6>
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
      <div class="page-header min-height-150 border-radius-xl" style="background-image: url('../../img/curved-images/curved0.jpg'); background-position-y: 50%;">
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
              <h5 class="mb-1"> Settled Bet </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4 pt-0 fit-content-body">      
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-flush dataTable-table" id="datatable-search">
                <thead class="thead-light">
                  <tr>
                    <th data-sortable="" style="width: 7.6743%;" class="asc">
                      <a href="#" class="dataTable-sorter text-lg">Id</a>
                    </th>
                    <th data-sortable="" style="width: 7%;" class="asc">
                      <a href="#" class="dataTable-sorter text-lg">Name</a>
                    </th>
                    <th data-sortable="" style="width: 16.382%;" class="">
                      <a href="#" class="dataTable-sorter text-lg">Date</a>
                    </th>
                    <th data-sortable="" style="width: 16.382%;" class="">
                      <a href="#" class="dataTable-sorter text-lg">Slip</a>
                    </th>
                    <th data-sortable="" style="width: 10.0658%;" class="">
                      <a href="#" class="dataTable-sorter text-lg">Amount</a>
                    </th>
                    <th data-sortable="" style="width: 19.6711%;" class="">
                      <a href="#" class="dataTable-sorter text-lg">Currency</a>
                    </th>
                    <th data-sortable="" style="width: 10.3909%;" class="">
                      <a href="#" class="dataTable-sorter text-lg">Odds</a>
                    </th>
                    <th>
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($active_json_data as $bet_one)                  
                      <tr class="border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" data-href="{{route('bet_single', ['bet_id' => $bet_one['id'], 'bet_type' => 2])}}">
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="customCheck1">
                            </div>
                            <p class="text-lg font-weight-bold ms-2 mb-0">{{$bet_one['id']}}</p>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex align-items-center">
                            <p class="text-lg font-weight-bold ms-2 mb-0">{{$bet_one['customer_name']}}</p>
                          </div>
                        </td>
                        <td class="font-weight-bold">
                          <span class="my-2 text-lg">{{$bet_one['created_at']}}</span>
                        </td>
                        <td class="text-lg font-weight-bold">
                          <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                              <i class="fas fa-check" aria-hidden="true"></i>
                            </button>
                            <span>{{$bet_one['slip']}}</span>
                          </div>
                        </td>
                        <td class="text-lg font-weight-bold">
                          <div class="d-flex align-items-center">
                            <span>{{$bet_one['amount']}}</span>
                          </div>
                        </td>
                        <td class="text-lg font-weight-bold">
                          <span class="my-2 text-lg">{{$bet_one['currency']}}</span>
                        </td>
                        <td class="text-lg font-weight-bold">
                          <span class="my-2 text-lg">{{$bet_one['odds']}}</span>
                        </td>
                        <td class="text-sm">
                          <a href="{{route('bet_single', ['bet_id' => $bet_one['id'], 'bet_type' => 2])}}" data-bs-toggle="tooltip" class=""  data-bs-original-title="Preview active bet">
                            <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
                          </a>                      
                          <!-- <a href="javascript:;" data-bs-toggle="tooltip" class="mx-3" data-bs-original-title="Delete active bet">
                            <i class="fas fa-trash text-secondary" aria-hidden="true"></i>
                          </a> -->
                        </td>
                      </tr>  
                  @endforeach               
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>            
    </div>
@endsection
@section('styles')
<link href="{{ asset('css/simple-datatable.css') }}" rel="stylesheet" />
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/plugins/simple-datatables.js') }}"></script>
<script>
    const dataTable = new simpleDatatables.DataTable("#datatable-search", {
        searchable: true,
        fixedHeight: false,        
        perPage: 6, // Show 3 rows per page
        perPageSelect: [6, 12, 24] // Options for rows per page
    });

    $(document).on('click', 'tr[data-href]', function (event) {     

      // Prevent event from firing when clicking on .btn-delete
      if ($(event.target).closest('.btn-delete-bet').length) {
          return;
      }
            
      window.location.href = this.dataset.href;
    });
</script>
@endsection
