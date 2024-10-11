<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/Datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Sweetalert2/sweetalert2.min.css') }}">
    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    @livewireScripts
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('js/Sweetalert2/sweetalert2.js') }}"></script>
    <!-- DataTables JS -->
    <script src="{{ asset('js/Datatables/datatables.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/umd/index.min.js"></script>
</body>

</html>
