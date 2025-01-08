<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Jayusman</title>
    <link rel="icon" href="{{ asset('/asset/img/logo.jpg') }}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/css/animate.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.css') }}">

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.js') }}"></script>

    <style>
        * {
            font-family: 'Poppins';
        }

        .kotak {
            color: #fff;
        }

        .table-style .today {
            background: #2A3F54;
            color: #ffffff;
        }

        .table-style th:nth-of-type(7),
        .table-style td:nth-of-type(7) {
            color: blue;
        }

        .table-style th:nth-of-type(1),
        .table-style td:nth-of-type(1) {
            color: red;
        }

        .table-style tr:first-child th {
            background-color: #F6F6F6;
            text-align: center;
            font-size: 15px;
        }
    </style>

    @yield('css')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
            </nav>

            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand bg-primary">
                        <img alt="image" src="{{ asset('/asset/img/logo.jpg') }}" width="60px" height="60px" class="rounded-circle mr-1">
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm bg-primary">
                        <a href="#"> Jayusman v2.1</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Jayusman v2.1</li>



                        @if(in_array(auth()->user()->role, ['owner', 'supervisor']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-users text-info"></i>
                                <span>Akun Pengguna</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('stores.index') }}">
                                <i class="fas fa-store text-info"></i>
                                <span>Stores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('audit_logs.index') }}">
                                <i class="fas fa-clipboard-list text-info"></i>
                                <span>Audit Logs</span>
                            </a>
                        </li>
                        @endif

                        @if(in_array(auth()->user()->role, ['owner','supervisor', 'manager', 'cashier']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transactions.index') }}">
                                <i class="fas fa-exchange-alt text-info"></i>
                                <span>Transactions</span>
                            </a>
                        </li>
                        @endif

                        @if(in_array(auth()->user()->role, ['owner','supervisor', 'manager', 'warehouse_staff']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="fas fa-box text-info"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        @endif


                        <li class="dropdown">
                            <a href="{{ route('logout') }}" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            @yield('content')

            <footer class="main-footer">
                <div class="footer-left">
                    &copy; 2023 <div class="bullet"></div> SIA v2.1 <div class="bullet"></div> Farijan
                </div>
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @yield('js')

    <script>
        @if(session()->has('success'))
        swal({
            type: "success",
            icon: "success",
            title: "BERHASIL!",
            text: "{{ session('success') }}",
            timer: 1500,
            showConfirmButton: false,
            showCancelButton: false,
            buttons: false,
        });
        @elseif(session()->has('error'))
        swal({
            type: "error",
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            timer: 1500,
            showConfirmButton: false,
            showCancelButton: false,
            buttons: false,
        });
        @endif
    </script>
    <script>
        document.querySelector('a[onclick]').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                document.getElementById('logout-form').submit();
            }
        });
    </script>

</body>

</html>
