<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 relative">
        <div class="absolute top-4 right-4 z-10">
            <div class="flex space-x-4 rtl:space-x-reverse bg-white p-2 rounded-lg shadow-sm border border-slate-200">
                <a href="{{ route('lang.switch', 'en') }}" class="text-sm px-2 {{ app()->getLocale() == 'en' ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">English</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('lang.switch', 'ar') }}" class="text-sm px-2 {{ app()->getLocale() == 'ar' ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">العربية</a>
            </div>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md rounded-lg border border-slate-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
