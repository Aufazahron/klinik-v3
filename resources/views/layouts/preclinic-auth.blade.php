<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('preclinic/assets/img/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Authentication' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('preclinic/assets/css/style.css') }}">
    <!--[if lt IE 9]>
		<script src="{{ asset('preclinic/assets/js/html5shiv.min.js') }}"></script>
		<script src="{{ asset('preclinic/assets/js/respond.min.js') }}"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('preclinic/assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('preclinic/assets/js/app.js') }}"></script>
</body>

</html>

