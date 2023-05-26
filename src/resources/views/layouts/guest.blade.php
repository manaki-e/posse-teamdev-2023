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

        <style>
            @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP&family=Patua+One&display=swap');

            .font-family-karla {
                font-family: karla;
            }

            .font-sans {
                font-family: 'Noto Sans JP', sans-serif;
            }

            .font-patua {
                font-family: 'Patua One', cursive;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 user-bg-gray">
            <div>
                <a href="/">
                    <x-application-logo class="mx-auto w-32 h-32 fill-current" />
                </a>
                <a href="/">
                    <p class="admin-text-green text-4xl font-patua">Peer Perk</p>
                </a>
            </div>

            <div class="w-full font-sans sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
