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
    <div class="row align-items-center mt-4">
        <div class="col-lg-12">
            <div class="nav-wrapper position-relative end-0">
                <!-- Navigation Tabs -->
                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#yearly-tabs-icons" role="tab" aria-controls="yearly-tabs-icons" aria-selected="true">
                            <i class="ni ni-chart-bar-32 text-sm me-2"></i> Yearly
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#monthly-tabs-icons" role="tab" aria-controls="monthly-tabs-icons" aria-selected="false">
                            <i class="ni ni-calendar-grid-58 text-sm me-2"></i> Monthly
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#weekly-tabs-icons" role="tab" aria-controls="weekly-tabs-icons" aria-selected="false">
                            <i class="ni ni-time-alarm text-sm me-2"></i> Weekly
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#daily-tabs-icons" role="tab" aria-controls="daily-tabs-icons" aria-selected="false">
                            <i class="ni ni-books text-sm me-2"></i> Daily
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Yearly Tab -->
                    <div class="tab-pane fade show active" id="yearly-tabs-icons" role="tabpanel" aria-labelledby="yearly-tab">
                        <div class="card z-index-2">
                            <div class="card-header pb-0">
                                <h6>Yearly overview</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-yearly" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Monthly Tab -->
                    <div class="tab-pane fade" id="monthly-tabs-icons" role="tabpanel" aria-labelledby="monthly-tab">
                        <div class="card z-index-2">
                            <div class="card-header pb-0">
                                <h6>Monthly overview</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-monthly" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Weekly Tab -->
                    <div class="tab-pane fade" id="weekly-tabs-icons" role="tabpanel" aria-labelledby="weekly-tab">
                        <div class="card z-index-2">
                            <div class="card-header pb-0">
                                <h6>Weekly overview</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-weekly" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Daily Tab -->
                    <div class="tab-pane fade" id="daily-tabs-icons" role="tabpanel" aria-labelledby="daily-tab">
                        <div class="card z-index-2">
                            <div class="card-header pb-0">
                                <h6>Daily overview</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-daily" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                @foreach ($all_websites as $website)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset($website['icon_url']) }}" class="avatar avatar-sm me-3" alt="xd" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">                                            
                                                <a href="{{$website['website_url']}}" class="mb-0 text-sm font-weight-bold" data-bs-toggle="tooltip" data-bs-placement="bottom" title="UnitBet" target="_blank">{{$website['name']}}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
                        @foreach ($all_coins as $coin)
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-credit-card text-success text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">{{$coin['name']}}</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    <span class="badge badge-sm {{$coin['background_classname']}}">{{$coin['address']}}</span>
                                </p>
                            </div>
                        </div>
                        @endforeach
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

    const yearlyData = @json($yearlyDataFormatted); // Format: { labels: [...], data: [...] }
    const monthlyData = @json($monthlyDataFormatted); // Format: { labels: [...], data: [...] }
    const weeklyData = @json($weeklyDataFormatted); // Format: { labels: [...], data: [...] }
    const dailyData = @json($dailyDataFormatted); // Format: { labels: [...], data: [...] }

    // Chart instance reference
    let chartInstance;
    
    function createChart(chartElementId, chartInfo) {
        const ctx = document.getElementById(chartElementId).getContext("2d");

        // Destroy existing chart instance to avoid overlap
        if (chartInstance) {
            chartInstance.destroy();
        }

        // Create new chart
        chartInstance = new Chart(ctx, {
            type: "line",
            data: {
                labels: chartInfo.labels, // Use specific labels
                datasets: [{
                    label: "Data",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#cb0c9f",
                    borderWidth: 3,
                    backgroundColor: 'transparent',
                    fill: true,
                    data: chartInfo.data, // Use specific data
                    maxBarThickness: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2,
                            },
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2,
                            },
                        },
                    },
                },
            },
        });
    }

    // Event listeners for tab switching
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', (e) => {
            const tabId = e.currentTarget.getAttribute('href');
            if (tabId === '#yearly-tabs-icons') {
                createChart('chart-yearly', yearlyData);
            } else if (tabId === '#monthly-tabs-icons') {
                createChart('chart-monthly', monthlyData);
            } else if (tabId === '#weekly-tabs-icons') {
                createChart('chart-weekly', weeklyData);
            } else if (tabId === '#daily-tabs-icons') {
                createChart('chart-daily', dailyData);
            }
        });
    });

    // Initialize the chart for the default tab (Yearly)
    createChart('chart-yearly', yearlyData);
</script>   
@endsection
