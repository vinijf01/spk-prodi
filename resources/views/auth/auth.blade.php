<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" /> --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/Top.png') }}" type="image/x-icon">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/assets_admin/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <link rel="stylesheet" href="{{ asset('/assets_admin/vendor/css/pages/page-auth.css') }}" />

</head>

<body>
    <!-- Content -->
    @yield('content')
    <!-- Main JS -->
    <script src="{{ asset('/assets_admin/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('/assets_admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('/assets_admin/js/main.js') }}"></script>
</body>

</html>
