@extends('layouts.frontend')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
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
    <div class="container-fluid py-4">      
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mx-auto">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Sports</p>
                            <h5 class="font-weight-bolder mb-0">
                                ${{$total}}
                                <!-- <span class="text-success text-sm font-weight-bolder">+55%</span> -->
                            </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mx-auto">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">NET</p>
                            <h5 class="font-weight-bolder mb-0">
                                ${{$net}}
                                <!-- <span class="text-success text-sm font-weight-bolder">+3%</span> -->
                            </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mx-auto">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">IRC</p>
                            <h5 class="font-weight-bolder mb-0">
                                ${{$irc}}
                                <!-- <span class="text-danger text-sm font-weight-bolder">-2%</span> -->
                            </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex flex-column h-100">                    
                            <h5 class="font-weight-bolder">Stepper's Dashboard</h5>
                            <p class="mb-5">Welcome to your dashboard.</p>                    
                            </div>
                        </div>
                        <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                            <div class="bg-gradient-primary border-radius-lg h-100">
                            <img src="{{ asset('img/shapes/waves-white.svg') }}" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">
                            <div class="position-relative d-flex align-items-center justify-content-center h-100">
                                <img class="w-100 position-relative z-index-2 img-border" src="{{ asset('img/dashboard/stepper.gif') }}" alt="rocket">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card h-100 p-3">
                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" 
                    style="background-image: url('../img/dashboard/server_banner.gif');">              
                </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Useful Sites</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <tbody>
                            <tr>
                                <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                    <img src="{{ asset('img/sites/unibet.webp') }}" class="avatar avatar-sm me-3" alt="xd">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Unit Bet</h6>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <a href="https://www.unibet.co.uk/betting/sports/home" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="UnitBet" target="_blank">
                                    <i class="fa fa-paperclip me-1 text-sm" aria-hidden="true"></i> UnitBet
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                    <img src="{{ asset('img/sites/ggbet.webp') }}" class="avatar avatar-sm me-3" alt="atlassian">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">GG bet</h6>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <a href="https://gg.bet/en" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="GGbet" target="_blank">
                                    <i class="fa fa-paperclip me-1 text-sm" aria-hidden="true"></i>GGbet
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                    <img src="{{ asset('img/sites/aceodds.webp') }}" class="avatar avatar-sm me-3" alt="team7">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Ace Odds</h6>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <a href="https://www.aceodds.com/bet-calculator/odds-converter.html" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ace Odds" target="_blank">
                                    <i class="fa fa-paperclip me-1 text-sm" aria-hidden="true"></i>Ace Odds
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                    <img src="{{ asset('img/sites/ggbet.webp') }}" class="avatar avatar-sm me-3" alt="atlassian">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">GG bet</h6>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <a href="https://gg.bet/en" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="GGbet" target="_blank">
                                    <i class="fa fa-paperclip me-1 text-sm" aria-hidden="true"></i>GGbet
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                    <img src="{{ asset('img/sites/ggbet.webp') }}" class="avatar avatar-sm me-3" alt="atlassian">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">GG bet</h6>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <a href="https://gg.bet/en" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="GGbet" target="_blank">
                                    <i class="fa fa-paperclip me-1 text-sm" aria-hidden="true"></i>GGbet
                                </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Personal Information</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline timeline-one-side">
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="ni ni-credit-card text-success text-gradient"></i>
                                    </span>
                                    <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bitcoin</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                        <span class="badge badge-sm bg-gradient-warning">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                <i class="ni ni-credit-card text-danger text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">ethereum</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    <span class="badge badge-sm bg-gradient-success">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                                </p>
                            </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                <i class="ni ni-credit-card text-info text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">litecoin</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    <span class="badge badge-sm bg-gradient-info">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                                </p>
                            </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                <i class="ni ni-credit-card text-warning text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">TRC20 USDT address</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    <span class="badge badge-sm bg-gradient-secondary">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                                </p>
                            </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                <i class="ni ni-credit-card text-primary text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">BEP20 USDT</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    <span class="badge badge-sm bg-gradient-primary">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                                </p>
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
@parent
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>   
@endsection
