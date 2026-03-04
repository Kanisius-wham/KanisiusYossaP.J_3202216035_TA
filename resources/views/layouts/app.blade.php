<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
 



  

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- NAVBAR MULAI -->
        <nav class="bg-gray-800 text-white w-full px-4 py-3 flex flex-wrap items-center justify-between">
            <!-- Brand/Logo kiri -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logosenentang.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="text-2xl font-bold">Senentang Outdoor</span>
            </a>

            <div class="flex-1 flex justify-center min-w-0 overflow-x-auto">
                <div class="flex space-x-4 md:space-x-8 items-center">
                    <a href="{{ url('/') }}" class="hover:underline text-sm md:text-lg font-semibold whitespace-nowrap">Beranda</a>
                    <a href="{{ url('/kategori') }}" class="hover:underline text-sm md:text-lg font-semibold whitespace-nowrap">Kategori</a>
                </div>
            </div>

            <div>
                <a href="{{ route('login') }}" class="hover:underline text-sm md:text-lg font-semibold whitespace-nowrap">Login Admin</a>
            </div>
        </nav>
        <!-- NAVBAR SELESAI -->

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    
   
</body>
</html>
