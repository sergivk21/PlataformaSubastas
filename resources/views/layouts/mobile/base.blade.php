<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        @include('layouts.mobile.navigation')
        
        <main class="flex-1">
            @yield('content')
        </main>
    </div>
    
    <footer class="mt-auto bg-white border-t border-gray-200">
        <div class="max-w-full mx-auto px-4 py-2">
            <p class="text-center text-gray-600">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/mobile-menu.js') }}" defer></script>
</body>
</html>
