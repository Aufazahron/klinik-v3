<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('preclinic/assets/img/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Dashboard' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/style.css') }}">
    <!--[if lt IE 9]>
		<script src="{{ asset('preclinic/assets/js/html5shiv.min.js') }}"></script>
		<script src="{{ asset('preclinic/assets/js/respond.min.js') }}"></script>
	<![endif]-->
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('preclinic/assets/img/logo.png') }}" width="35" height="35" alt=""> <span>Preclinic</span>
                </a>
            </div>
            <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="{{ asset('preclinic/assets/img/user.jpg') }}" width="24" alt="User">
                            <span class="status online"></span>
                        </span>
                        <span>{{ Auth::user()->full_name ?? 'User' }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                        </form>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ request()->routeIs('practitioners.*') ? 'active' : '' }}">
                            <a href="{{ route('practitioners.index') }}"><i class="fa fa-users"></i> <span>Manajemen User</span></a>
                        </li>
                        <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}"><i class="fa fa-shield"></i> <span>Manajemen Role</span></a>
                        </li>
                        <li class="{{ request()->routeIs('insurances.*') ? 'active' : '' }}">
                            <a href="{{ route('insurances.index') }}"><i class="fa fa-id-card-alt"></i> <span>Manajemen Asuransi</span></a>
                        </li>
                        <li class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                            <a href="{{ route('departments.index') }}">
                                <i class="fa fa-hospital-o"></i>
                                <span>Manajemen Poli</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('patients.*') ? 'active' : '' }}">
                            <a href="{{ route('patients.index') }}">
                                <i class="fa fa-users"></i>
                                <span>Manajemen Pasien</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('encounters.*') ? 'active' : '' }}">
                            <a href="{{ route('encounters.index') }}">
                                <i class="fa fa-calendar-check-o"></i>
                                <span>Pendaftaran & Antrian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="{{ asset('preclinic/assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>

