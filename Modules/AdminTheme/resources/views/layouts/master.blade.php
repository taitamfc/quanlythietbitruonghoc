<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminTheme Module - {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ $author ?? '' }}">

    <!-- Fonts -->
    <!--plugins-->
    <link href="{{ asset('admin-assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
    <!-- loader-->
	<link href="{{ asset('admin-assets/css/pace.min.css') }}" rel="stylesheet">
	<script src="{{ asset('admin-assets/js/pace.min.js') }}"></script>
    <!--Styles-->
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/icons.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/dark-theme.css') }}" rel="stylesheet">

    {{-- Vite CSS --}}
    {{-- {{ module_vite('build-admintheme', 'resources/assets/sass/app.scss') }} --}}
    @yield('header')
</head>

<body>
    @extends('admintheme::includes.header')
    @extends('admintheme::includes.sidebar')
    <main class="page-content">
        @yield('content')
    </main>
    @extends('admintheme::includes.footer')

    <script src="{{ asset('admin-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/simplebar/js/simplebar.min.js') }}"></script>

    <!--BS Scripts-->
    <script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/main.js') }}"></script>

    {{-- Vite JS --}}
    {{-- {{ module_vite('build-admintheme', 'resources/assets/js/app.js') }} --}}
    @yield('footer')
</body>
