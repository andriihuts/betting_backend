@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Transaction</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Transaction</h6>
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
              <h5 class="mb-1"> Transaction </h5>              
            </div>
          </div>          
        </div>
      </div>
    </div>
    <!-- End Navbar -->
    <div class="container-fluid py-4 fit-content-body">
      <div class="row">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Your Transaction's</h6>
                </div>               
              </div>
            </div>
            <div class="card-body pt-4 p-3">
              <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
              <ul class="list-group">
                @foreach ($todayTransactions as $latest)
                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded {{$latest->amount < 0? 'btn-outline-danger': 'btn-outline-info'}}  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                        <i class="fas {{$latest->amount < 0? 'fa-arrow-down': 'fa-arrow-up'}}" aria-hidden="true"></i>
                      </button>
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">{{$latest->description}}</h6>
                        <span class="text-xs">{{$latest->formatted_created_at}}</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center {{$latest->amount < 0? 'text-danger': 'text-info'}}  text-gradient text-lg font-weight-bold">{{$latest->amount < 0? '-': ''}} ${{abs($latest->amount)}}</div>
                  </li>   
                @endforeach            
              </ul>
              <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Yesterday</h6>
              <ul class="list-group">
                @foreach ($yesterdayTransactions as $yesterday)
                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded {{$yesterday->amount < 0? 'btn-outline-danger': 'btn-outline-info'}}  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                        <i class="fas {{$yesterday->amount < 0? 'fa-arrow-down': 'fa-arrow-up'}}" aria-hidden="true"></i>
                      </button>
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">{{$yesterday->description}}</h6>
                        <span class="text-xs">{{$yesterday->formatted_created_at}}</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center {{$yesterday->amount < 0? 'text-danger': 'text-info'}}  text-gradient text-lg font-weight-bold">{{$yesterday->amount < 0? '-': ''}} ${{abs($yesterday->amount)}}</div>
                  </li>   
                @endforeach                
              </ul>
            </div>           
          </div>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Total Transaction List</h6>
                </div>                
              </div>
            </div>
            <div class="card-body pt-4 p-3">              
              <ul class="list-group">
                @foreach ($totalTransactions as $total)
                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded {{$total->amount < 0? 'btn-outline-danger': 'btn-outline-info'}}  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                        <i class="fas {{$total->amount < 0? 'fa-arrow-down': 'fa-arrow-up'}}" aria-hidden="true"></i>
                      </button>
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">{{$total->description}}</h6>
                        <span class="text-xs">{{$total->formatted_created_at}}</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center {{$total->amount < 0? 'text-danger': 'text-info'}}  text-gradient text-lg font-weight-bold">{{$total->amount < 0? '-': ''}} ${{abs($total->amount)}}</div>
                  </li>  
                @endforeach                             
              </ul>             
            </div>
            <div class="card-footer d-flex justify-content-center p-0">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item">
                    <a class="page-link" href="javascript:;" aria-label="Previous">
                      <i class="fa fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
                  <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
                  <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:;" aria-label="Next">
                      <i class="fa fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>      
    </div>
@endsection
@section('scripts')
@parent 
@endsection
