<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{ asset('css\Datatables\datatables.css') }}">

        <!-- jQuery -->
       <script src="{{ asset('js\jquery.js') }}"></script>

       <!-- DataTables JS -->
       <script src="{{ asset('js\Datatables\datatables.js') }}"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 text-black/50">
            <div class="relative min-h-screen flex flex-col py-4 selection:bg-[#FF2D20] selection:text-white">
              <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="flex justify-between">
                        <div class="">
                          <div class="rounded px-2 border-4 border-gray-900 text-gray-900 font-bold text-xl">SPR</div>
                        </div>
                        @if (Route::has('login'))
                            <nav class="flex gap-x-1">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6">
                      {{-- Body --}}
                      <div class="text-xl font-bold">
                        Welcome to Solar Panel Repair
                      </div>
                    </main>
                    
                    </div>
                    <footer class="py-16 text-center text-sm text-black">
                      
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>

