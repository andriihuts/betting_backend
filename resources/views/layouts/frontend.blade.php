<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Stepper Betting Website</title>
        <!-- Fonts and icons -->        
        <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" />    
        <!-- Nucleo Icons -->    
        <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />    
        <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>     -->
        <!-- CSS Files -->    
        <link id="pagestyle" href="{{ asset('css/soft-ui-dashboard.css') }}" rel="stylesheet" />        
        <script src="{{ asset('js/plugins/kit-fontawesome.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery-3.6.0.min.js') }}"></script>
        @yield('styles')
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    </head>
    <body class="g-sidenav-show  bg-gray-100">        
        <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
            <div class="sidenav-header">
                <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                <div class="navbar-brand m-0">
                    <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
                    <span class="ms-1 font-weight-bold">Stepper Dashboard</span>
                </div>
            </div>
            <hr class="horizontal dark mt-0">
            <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
                @include('partials.menu')
            </div>
        </aside>
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lgz fit-main-content">
            @yield('content')
            <footer class="footer pt-3">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="../pages/dashboard.html" class="font-weight-bold" target="_blank">Stepper Group</a>
                        for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end footer-menu">
                        <li class="nav-item">
                            <a href="{{ route('bet_new') }}" class="nav-link text-muted" target="_blank">NEW BET</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bet_list', 3)}}" class="nav-link text-muted" target="_blank">Active BET</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bet_list', 1)}}" class="nav-link text-muted" target="_blank">Settled bet</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tabs') }}" class="nav-link pe-0 text-muted" target="_blank">Tabs</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payment_get_irc') }}" class="nav-link pe-0 text-muted" target="_blank">IRC</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers_all') }}" class="nav-link pe-0 text-muted" target="_blank">Customers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payment_get_misc') }}" class="nav-link pe-0 text-muted" target="_blank">Misc</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payment_transaction') }}" class="nav-link pe-0 text-muted" target="_blank">Transaction</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('currency_all') }}" class="nav-link pe-0 text-muted" target="_blank">Currencies</a>
                        </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </footer>
        </main>
         <!--   Core JS Files   -->
         <script src="{{ asset('js/core/popper.min.js') }}"></script>
         <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
         <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
         <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
         <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
         <script src="{{ asset('js/plugins/datatables.js') }}"></script>       

         @yield('scripts')        
         <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
    </body>
</html>