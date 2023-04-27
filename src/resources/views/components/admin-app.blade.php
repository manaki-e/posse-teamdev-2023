<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        .bg-sidebar {
            background: #079292;
        }

        .cta-btn {
            color: #3d68ff;
        }
    </style>
</head>

<body class="admin-bg-basic font-family-karla">
    <div class="flex overflow-hidden">
        <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
            <x-admin-sidebar></x-admin-sidebar>
        </aside>
        <div class="h-full w-full relative overflow-y-auto mx-4">
            <div class="flex">
                <x-application-logo class="w-16 h-16 fill-current text-gray-500 rounded-full"></x-application-logo>
                <x-application-title class="font-bold text-4xl"></x-application-title>
            </div>
            <main>
                <x-admin-title>
                    <x-slot name="title">
                        {{ $title }}
                    </x-slot>
                    <x-slot name="discription">
                        {{ $discription }}
                    </x-slot>
                </x-admin-title>
            </main>
        </div>
    </div>
</body>

</html>
